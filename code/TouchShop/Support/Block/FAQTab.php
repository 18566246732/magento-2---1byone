<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/22/18
 * Time: 11:03 PM
 */

namespace TouchShop\Support\Block;


use Magento\Framework\View\Element\Template;
use TouchShop\Support\Helper\FAQHelper;

class FAQTab extends Template
{
    protected $_registry;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    )
    {
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    public function getFAQ()
    {
        $product = $this->_registry->registry('current_product');
        return FAQHelper::getFAQ($product);
    }

    public function addFaqAction()
    {
        return $this->getBaseUrl() . '/support/add/faq';
    }

}