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

    public function __construct(
        ReviewAdvancedCollection $collection,
        Configurable $configurable,
        CollectionFactory $collectionFactory
    )
    {
        $this->reviewAdvancedCollection = $collection;
        $this->productCollectionFactory = $collectionFactory;
        $this->configurable = $configurable;
    }


    public function execute()
    {
//        HttpHelper::post('', []);

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

    private function addReview($review)
    {
        $product_id = $this->getMainProductByAsin($review['asin']);
        if ($product_id) {
            $data = [
                'nickname' => $review['author'],
                'title' => $review['title'],
                'detail' => $review['content']
            ];

            $rating = [
                'rating_id' => 4,
                'rating_value' => $review['star']
            ];
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