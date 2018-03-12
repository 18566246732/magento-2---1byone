<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/3/18
 * Time: 2:43 AM
 */

namespace TouchShop\ProductTool\Block;


use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class AmazonASIN extends Template
{
    /** @var Registry */
    private $registry;


    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    )
    {
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    public function getAmazonASIN()
    {
        $product = $this->registry->registry('current_product');
        $customAttribute = $product->getCustomAttribute('amazon_asin');
        if ($customAttribute) {
            $asin = $customAttribute->getValue();
            if ($asin) {
                return $asin;
            }
        }
        return null;
    }
}