<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/9/18
 * Time: 6:40 PM
 */

namespace TouchShop\Basic\Helper;


use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Customer\Model\Session;

class CustomerHelper
{
    /**
     * @param $session Session
     * @param $customerRepository CustomerRepository
     * @return mixed
     */
    public static function getLoginInfo($session, $customerRepository)
    {
        $isLogin = $session->isLoggedIn();
        if ($isLogin) {
            $customer_id = $session->getCustomerId();
            $customer = $customerRepository->getById($customer_id);
            $result['email'] = $customer->getEmail();
            $result['vip'] = 1;
        } else {
            $result['vip'] = 0;
        }
        return $result;
    }

}