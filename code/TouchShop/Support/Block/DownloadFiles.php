<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/23/18
 * Time: 10:05 PM
 */

namespace TouchShop\Support\Block;


use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use TouchShop\Support\Helper\DownloadFilesHelper;

class DownloadFiles extends Template
{

    protected $_registry;

    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    )
    {
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    public function getDownloadFiles()
    {
        $product = $this->_registry->registry('current_product');
        return DownloadFilesHelper::getDownloadFiles($product);
    }

}