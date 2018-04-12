<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/26/18
 * Time: 5:09 PM
 */

namespace TouchShop\Feedback\Block;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;
use TouchShop\Basic\Helper\CustomerHelper;
use TouchShop\ProductTool\Helper\CategoryHelper;

class Complain extends Template
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
        return $this->getBaseUrl() . 'feedback';
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
}