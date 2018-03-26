<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/22/18
 * Time: 8:12 PM
 */

namespace TouchShop\ReviewTool\Cron;


use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Review\Model\RatingFactory;
use Magento\Review\Model\Review;
use Magento\Review\Model\ReviewFactory;
use TouchShop\Basic\Helper\HttpHelper;
use TouchShop\ProductTool\Helper\ProductHelper;
use TouchShop\ReviewTool\Model\ResourceModel\ReviewAdvanced\ReviewAdvancedCollection;

class SyncReviews
{
    /** @var ReviewAdvancedCollection */
    private $reviewAdvancedCollection;

    /**@var CollectionFactory */
    private $productCollectionFactory;

    /**@var Configurable */
    private $configurable;

    /**@var ReviewFactory */
    private $reviewFactory;

    /**@var \Magento\Review\Model\ResourceModel\Review */
    private $reviewResourceModel;

    /** @var RatingFactory */
    private $ratingFactory;


    public function __construct(
        ReviewAdvancedCollection $collection,
        Configurable $configurable,
        ReviewFactory $reviewFactory,
        \Magento\Review\Model\ResourceModel\Review $reviewResourceModel,
        RatingFactory $ratingFactory,
        CollectionFactory $collectionFactory
    )
    {
        $this->reviewAdvancedCollection = $collection;
        $this->productCollectionFactory = $collectionFactory;
        $this->reviewFactory = $reviewFactory;
        $this->ratingFactory = $ratingFactory;
        $this->reviewResourceModel = $reviewResourceModel;
        $this->configurable = $configurable;
    }


    /**
     * @throws \Exception
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute()
    {
        $resp = HttpHelper::post('http://192.168.0.153:8080/reviewListByCondition', [
            "filter" => [
                "has_output" => false
            ],
            "pageSize" => 100,
            "pageNum" => 1
        ]);

        $data = $resp;

        $data = [
            'reviews' => [
                ['review_id' => 'aaab']
            ]
        ];

        if (isset($data['reviews'])) {
            foreach ($data['reviews'] as $review) {
                $origin = $review['review_id'];
                $collection = $this->reviewAdvancedCollection->addFieldToFilter(
                    'origin', $origin
                )->load();
                if ($collection->getSize() == 0) {
                    $this->addReview($review);
                }
            }
        }
    }

    /**
     * @param $review
     * @throws \Exception
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    private function addReview($review)
    {
        $product_id = $this->getMainProductByAsin($review['asin']);
        if ($product_id) {
            $data = [
                'nickname' => $review['author'],
                'title' => $review['title'],
                'detail' => $review['content']
            ];
            $entity = $this->reviewFactory->create()->setData($data);
            $entity->unsetData('review_id');

            $validate = $entity->validate();
            if ($validate === true) {
                $entity->setEntityId($entity
                    ->getEntityIdByCode(Review::ENTITY_PRODUCT_CODE))
                    ->setEntityPkValue($product_id)
                    ->setStatusId(Review::STATUS_PENDING)
                    ->setCusomerId(null)
                    ->setCreatedAt(strtotime($review['date']))
                    ->setStoreId(null)
                    ->setStores([null]);
                // todo
                $this->reviewResourceModel->save($entity);

                $optionId = 15 + $review['star'];

                $this->ratingFactory->create()
                    ->setReviewId($entity->getId())
                    ->setCustomerId(null)
                    ->addOptionVote($optionId, $product_id);

                $entity->aggregate();
            }
        }
    }

    private function getMainProductByAsin($asin)
    {
        $collection = $this->productCollectionFactory->create()->addAttributeToFilter(
            ProductHelper::AMAZON_ASIN, $asin
        )->load();
        if ($collection->getSize() > 0) {
            /**@var Product $product */
            $product = $collection->getItems()[0];
            if (ProductHelper::isSimple($product)) {
                $parents = $this->configurable->getParentIdsByChild($product->getId());
                if (count($parents) > 0) {
                    return $parents[0];
                }
            }
        }
        return null;

    }
}