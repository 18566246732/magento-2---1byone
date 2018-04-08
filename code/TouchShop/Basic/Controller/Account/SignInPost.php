<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/7/18
 * Time: 3:58 AM
 */

namespace TouchShop\Basic\Controller\Account;


use Magento\Customer\Model\AccountManagement;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class SignInPost extends Action
{
    private $customerAccountManagement;
    private $session;

    public function __construct(
        Context $context,
        AccountManagement $management,
        Session $session
    )
    {
        parent::__construct($context);
        $this->customerAccountManagement = $management;
        $this->session = $session;
    }


    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        if ($this->getRequest()->isPost()) {
            $login = $this->getRequest()->getPost('login');
            if (!empty($login['username']) && !empty($login['password'])) {
                try {
                    $customer = $this->customerAccountManagement->authenticate($login['username'], $login['password']);
                    $this->session->setCustomerDataAsLoggedIn($customer);
                    $this->session->regenerateId();
                    $result->setData(['result' => 'success', 'status_code' => 200]);
                    return $result;
                } catch (\Exception $e) {
                    $result->setData(['result' => 'fail', 'status_code' => 400, 'error_message' => $e->getMessage()]);
                    return $result;
                }
            }
            return $result->setData(['result' => 'fail', 'status_code' => 400, 'error_message' => 'username or password is empty']);
        }
    }
}