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
        $customAttribute = $product->getCustomAttribute('amazon_url');
        if ($customAttribute) {
            $url = $customAttribute->getValue();
            if ($url) {
                return $url;
            }
        }
        return 'https://www.amazon.com';
    }

    public function getLinkLabel()
    {
        return 'Buy at Amazon';
    }

}