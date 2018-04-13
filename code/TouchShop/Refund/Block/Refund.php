<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/26/18
 * Time: 11:21 PM
 */

namespace TouchShop\Refund\Block;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;
use TouchShop\Basic\Helper\CustomerHelper;
use TouchShop\ProductTool\Helper\CategoryHelper;
use TouchShop\Refund\Helper\Options;

class Refund extends Template
{
    private $session;
    private $customerRepository;
    private $categoryRepository;

    public function __construct(
        Session $session,
        CustomerRepository $customerRepository,
        CategoryRepository $categoryRepository,
        Template\Context $context,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->session = $session;
        $this->customerRepository = $customerRepository;
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * Retrieve form action
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getBaseUrl() . 'refund';
    }

    public function getBaseImgUrl($imgName)
    {
        return $this->getBaseUrl() . 'pub/media/refund-exchange/' . $imgName;
    }

    public function getLoginInfo()
    {
        $loginInfo = CustomerHelper::getLoginInfo($this->session, $this->customerRepository);
        return json_encode($loginInfo);
    }

    public function getCategories()
    {
        return CategoryHelper::getCategories($this->categoryRepository);
    }

    public function getReasons()
    {
        return Options::getReasons();
    }


    public function getStates()
    {
        return Options::getStates();
    }

    public function getCountries()
    {
        return Options::getCountries();
    }

}