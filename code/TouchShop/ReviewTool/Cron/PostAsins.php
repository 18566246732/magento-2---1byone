<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/22/18
 * Time: 6:14 AM
 */

namespace TouchShop\ReviewTool\Cron;


use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Psr\Log\LoggerInterface;
use TouchShop\Basic\Helper\HttpHelper;
use TouchShop\ProductTool\Helper\ProductHelper;
use TouchShop\ReviewTool\Helper\Config;

class PostAsins
{
    private $collectionFactory;
    private $configurable;
    /**@var ProductRepositoryInterface */
    private $repository;
    private $logger;

    public function __construct(
        Configurable $configurable,
        ProductRepositoryInterface $repository,
        LoggerInterface $logger,
        CollectionFactory $collectionFactory
    )
    {
        $this->logger = $logger;
        $this->configurable = $configurable;
        $this->repository = $repository;
        $this->collectionFactory = $collectionFactory;
    }


    /**
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $asins = [];
        $collection = $this->collectionFactory->create()->addAttributeToSelect(ProductHelper::AMAZON_ASIN)->load();

        /**@var $product Product */
        foreach ($collection as $product) {
            $asin = ProductHelper::getAsin($product);
            if (ProductHelper::isSimple($product) && empty($this->configurable->getParentIdsByChild($product->getId()))) {
                if ($asin) {
                    $asins[] = $asin;
                }
            } elseif (ProductHelper::isConfigurable($product)) {
                $children = ProductHelper::getChildren($product);
                $asin_list = [];
                /**@var Product $child */
                foreach ($children as $child) {
                    /**@var Product $childProduct */
                    $childProduct = $this->repository->getById($child->getId());
                    $asin = ProductHelper::getAsin($childProduct);
                    if ($asin) {
                        $asin_list[] = $asin;
                    }
                }
                if (count($asin_list) > 0) {
                    $asins[] = join(',', $asin_list);
                }
            }
        }


        $this->logger->error('find asins' . json_encode($asins));
        $resp = HttpHelper::post(
            'http://' . Config::IP . ':' . Config::PORT . '/saveAsin',
            ['asin_arr' => $asins]
        );
        $this->logger->error('resp of post asin :' . json_encode($resp));
    }
}