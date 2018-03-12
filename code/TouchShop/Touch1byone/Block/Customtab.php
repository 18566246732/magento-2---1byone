<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/22/18
 * Time: 11:03 PM
 */

namespace TouchShop\Touch1byone\Block;


use Magento\Framework\View\Element\Template;

class Customtab extends Template
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
        $faq = $product->getCustomAttribute('product_faq');
        if (null != $faq) {
            return $faq->getValue();
        }
        return 'Hello\n FAQ!';
    }

}