<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/22/18
 * Time: 6:14 AM
 */

namespace TouchShop\ReviewTool\Cron;


use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use TouchShop\Basic\Helper\HttpHelper;
use TouchShop\ProductTool\Helper\ProductHelper;

class PostAsins
{
    const SIMPLE = 'simple';
    const CONFIGURABLE = Configurable::TYPE_CODE;

    private $collectionFactory;
    private $configurable;

    public function __construct(
        Configurable $configurable,
        CollectionFactory $collectionFactory
    )
    {
        $this->configurable = $configurable;
        $this->collectionFactory = $collectionFactory;
    }


    public function execute()
    {
        $asins = [];
        $collection = $this->collectionFactory->create()->addAttributeToSelect('*')->load();

        /**@var $product Product */
        foreach ($collection as $product) {
            $asin = ProductHelper::getAsin($product);
            if ($asin) {
                if ($this->isSimple($product)) {
                    $asins[] = $asin;
                } elseif ($this->isConfigurable($product)) {
                    $children = $product->getTypeInstance()->getUsedProducts($product);
                    $asin_list = [];
                    foreach ($children as $child) {
                        $asin = ProductHelper::getAsin($child);
                        if ($asin) {
                            $asin_list[] = $asin;
                        }
                    }
                    $asins[] = join(',', $asin_list);
                }
            }
        }

        HttpHelper::post('', $asins);
    }

    private function isSimple(Product $product)
    {
        return $product->getTypeId() == self::SIMPLE && empty($this->configurable->getParentIdsByChild($product->getId()));
    }

    private function isConfigurable(Product $product)
    {
        return $product->getTypeId() == self::CONFIGURABLE;
    }

}