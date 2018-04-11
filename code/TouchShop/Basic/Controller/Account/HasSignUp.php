<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/10/18
 * Time: 6:35 AM
 */

namespace TouchShop\Basic\Controller\Account;


use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class HasSignUp extends Action
{
    private $repository;

    public function __construct(
        Context $context,
        CustomerRepository $repository
    )
    {
        parent::__construct($context);
        $this->repository = $repository;
    }


    public function execute()
    {
        $ajax = [];
        try {
            $data = (array)$this->getRequest()->getPost();
            if (isset($data['email'])) {
                $email = $data['email'];
                $customer = $this->repository->get($email);#todo
                if ($customer) {
                    $ajax['vip'] = 1;
                } else {
                    $ajax['vip'] = 0;
                }
            }
        } catch (\Exception $e) {
            $ajax['vip'] = 0;
        }
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $result->setData($ajax);
        return $result;
    }
}