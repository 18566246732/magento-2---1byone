<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/7/18
 * Time: 4:22 AM
 */

namespace TouchShop\Basic\Controller\Account;


use Magento\Customer\Model\AccountManagement;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\ResourceModel\Customer;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\StoreManagerInterface;

class CreatePost extends Action
{
    private $session;
    private $storeManager;
    private $customerFactory;
    private $resourceModel;
    private $customerAccountManagement;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        CustomerFactory $customerFactory,
        Customer $customer,
        AccountManagement $management,
        Session $session
    )
    {
        parent::__construct($context);
        $this->session = $session;
        $this->storeManager = $storeManager;
        $this->resourceModel = $customer;
        $this->customerFactory = $customerFactory;
        $this->customerAccountManagement = $management;
    }


    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        try {
            $post = $this->getRequest()->getPost();
            $websiteId = $this->storeManager->getWebsite()->getId();
            $customer = $this->customerFactory->create();
            $customer->setWebsiteId($websiteId);
            $customer->setEmail($post['email']);
            $customer->setFirstname($post['firstname']);
            $customer->setLastname($post['lastname']);
            $customer->setPassword($post['password']);
            $this->resourceModel->save($customer);


            $customer = $this->customerAccountManagement->authenticate($post['email'], $post['password']);
            $this->session->setCustomerDataAsLoggedIn($customer);
            $this->session->regenerateId();
            $result->setData(['result' => 'success', 'status_code' => 200]);
            return $result;
        } catch (\Exception $e) {
            $result->setData(['result' => 'fail', 'status_code' => 400]);
            return $result;
        }
    }
}