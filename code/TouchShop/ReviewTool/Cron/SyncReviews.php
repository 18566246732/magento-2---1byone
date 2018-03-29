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
use TouchShop\ReviewTool\Model\ResourceModel\ReviewAdvancedResourceModel;
use TouchShop\ReviewTool\Model\ReviewAdvanced;
use TouchShop\ReviewTool\Model\ReviewAdvancedFactory;

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

    /** @var ReviewAdvancedResourceModel */
    private $reviewAdvancedResourceModel;

    /** @var ReviewAdvancedFactory */
    private $reviewAdvancedFactory;


    public function __construct(
        ReviewAdvancedCollection $collection,
        ReviewAdvancedFactory $reviewAdvancedFactory,
        ReviewAdvancedResourceModel $reviewAdvancedResourceModel,
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
        $this->reviewAdvancedFactory = $reviewAdvancedFactory;
        $this->reviewAdvancedResourceModel = $reviewAdvancedResourceModel;
    }


    /**
     * @throws \Exception
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute()
    {
//        $resp = HttpHelper::post('http://192.168.0.153:8080/reviewListByCondition', [
//            "filter" => [
//                "has_output" => false
//            ],
//            "pageSize" => 100,
//            "pageNum" => 1
//        ]);
//
//        $data = $resp;

        $data = [
            'reviews' => [
                [
                    'review_id' => 'RXSZE4AXM7JNR' . time(),
                    'star' => 2,
                    'title' => 'Two Stars',
                    'content' => 'Too slippery;;',
                    'imgs_url' => '',
                    'video_url' => '',
                    'type' => 'Color: Rose Gold',
                    'date' => '2018-03-09',
                    'author' => 'bostonrenner',
                    'verified_purchase' => 'Verified Purchase',
                    'asin' => 'B077ZMVNS2',
                    'helpful' => 0
                ]
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
        $product_id = $this->getProductByAsin($review['asin']);
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
                    ->setStoreId(1)
                    ->setStores([1]);
                // todo
                $this->reviewResourceModel->save($entity);

                $this->addReviewAdvanced($entity->getId(), $review);

                $optionId = $review['star'];

                $this->ratingFactory->create()
                    ->setRatingId(4)
                    ->setReviewId($entity->getId())
                    ->setCustomerId(null)
                    ->addOptionVote($optionId, $product_id);

                $entity->aggregate();
            }
        }
    }

    /**
     * @param $review_id
     * @param $review
     * @throws \Exception
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    private function addReviewAdvanced($review_id, $review)
    {
        /**@var $advanced ReviewAdvanced */
        $advanced = $this->reviewAdvancedFactory->create();
        $advanced->setReviewId($review_id);
        $advanced->setVerifiedPurchase($review['verified_purchase']);
        $advanced->setFormat($review['type']);
        $advanced->setHelpful($review['helpful']);
        $advanced->setOrigin($review['review_id']);
        $advanced->setImageUrls($review['imgs_url']);
        $advanced->setVideoUrls($review['video_url']);

        $this->reviewAdvancedResourceModel->save($advanced);
    }

    private function getProductByAsin($asin)
    {
        $collection = $this->productCollectionFactory->create()->addAttributeToFilter(
            ProductHelper::AMAZON_ASIN, $asin
        )->load();
        if ($collection->getSize() > 0) {
            return current(array_keys($collection->getItems()));
        }
        return null;

    }
}