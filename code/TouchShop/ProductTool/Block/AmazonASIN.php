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
use TouchShop\ProductTool\Helper\ProductHelper;

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
        return ProductHelper::getAsin($product);

    }
}