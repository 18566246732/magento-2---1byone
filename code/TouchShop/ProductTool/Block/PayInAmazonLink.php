<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/2/18
 * Time: 5:43 PM
 */

namespace TouchShop\ProductTool\Block;


use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use TouchShop\ProductTool\Helper\ProductHelper;

class PayInAmazonLink extends Template
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

    /**
     * @return string
     */
    public function getLinkUrl()
    {
        $product = $this->registry->registry('current_product');
        return ProductHelper::getAmazonUrl($product);
    }

    public function getLinkLabel()
    {
        return ProductHelper::BY_AT_AMAZON_LINK_LABEL;
    }

}