<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/22/18
 * Time: 11:03 PM
 */

namespace TouchShop\Support\Block;


use Magento\Backend\Block\Template\Context;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Customer\Model\Session;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use TouchShop\Basic\Helper\CustomerHelper;
use TouchShop\Support\Helper\FAQHelper;

class FAQTab extends Template
{
    protected $_registry;
    private $repository;
    private $session;

    public function __construct(
        Context $context,
        Registry $registry,
        Session $session,
        CustomerRepository $repository,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_registry = $registry;
        $this->session = $session;
        $this->repository = $repository;
    }

    public function getFAQ()
    {
        $product = $this->_registry->registry('current_product');
        return FAQHelper::getFAQ($product);
    }

    public function getFaqAction()
    {
        return $this->getBaseUrl() . 'support/add/faq';
    }

    public function getLoginInfo()
    {
        $loginInfo = CustomerHelper::getLoginInfo($this->session, $this->repository);
        return json_encode($loginInfo);
    }

}