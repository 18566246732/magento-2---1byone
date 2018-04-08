<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/26/18
 * Time: 11:21 PM
 */

namespace TouchShop\PowerUser\Block;

use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;
use TouchShop\PowerUser\Model\ResourceModel\PowerUser\PowerUserCollection;

class PowerUser extends Template
{
    private $session;
    private $powerUserCollection;
    private $customerRepository;

    public function __construct(
        Session $session,
        PowerUserCollection $powerUserCollection,
        CustomerRepository $customerRepository,
        Template\Context $context,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->session = $session;
        $this->powerUserCollection = $powerUserCollection;
        $this->customerRepository = $customerRepository;
    }


    /**
     * Retrieve form action
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('power-user');
    }

    public function getBaseImgUrl($imgName)
    {
        return $this->getBaseUrl() . 'pub/media/poweruser/' . $imgName;
    }

    public function getAjax()
    {
        $result = [];
        $isLogin = $this->session->isLoggedIn();
        if ($isLogin) {
            $customer_id = $this->session->getCustomerId();
            $customer = $this->customerRepository->getById($customer_id);
            $result['email'] = $customer->getEmail();
            $this->powerUserCollection->addFieldToFilter('customer_id', $customer_id);
            $size = $this->powerUserCollection->getSize();
            if ($size) {
                $result['vip'] = 2;
                $entity = $this->powerUserCollection->getItems()[$customer_id];
                $interests = $entity->getInterests();
                if ($interests) {
                    $result['interests'] = preg_split(',', $interests);
                }
            } else {
                $result['vip'] = 1;
            }

        } else {
            $result['vip'] = 0;
        }

        return json_encode($result);
    }
}