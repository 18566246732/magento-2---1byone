<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/7/18
 * Time: 2:09 AM
 */

namespace TouchShop\PowerUser\Controller\HasSignUp;


use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use TouchShop\PowerUser\Model\ResourceModel\PowerUser\PowerUserCollection;

class Index extends Action
{
    private $repository;
    private $collection;

    public function __construct(
        Context $context,
        CustomerRepository $repository,
        PowerUserCollection $collection
    )
    {
        parent::__construct($context);
        $this->repository = $repository;
        $this->collection = $collection;
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
                    $customer_id = $customer->getId();
                    $this->collection->addFieldToFilter('customer_id', $customer_id);
                    $items = $this->collection->getItems();
                    if (count($items) > 0) {
                        $ajax['vip'] = 2;
                        $entity = $items[$customer_id];
                        $ajax['interests'] = preg_split(',', $entity->getInterests());
                    } else {
                        $ajax['vip'] = 1;
                    }
                } else {
                    $ajax['vip'] = 0;
                }
            }
        } catch (\Exception $e) {
            $ajax['vip'] = 0;
            $ajax['error_message'] = $e->getMessage();
        }
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $result->setData($ajax);
        return $result;
    }
}