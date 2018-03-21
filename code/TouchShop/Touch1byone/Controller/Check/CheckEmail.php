<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/20/18
 * Time: 7:01 PM
 */

namespace TouchShop\Touch1byone\Controller\Check;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

class CheckLogin extends Action
{

    private $collectionFactory;

    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory
    )
    {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        $response = 'false';
        $post = (array)$this->getRequest()->getPost();
        $post = [
            'email' => 'roni_cost@example.com'
        ];
        if ($post) {
            if (isset($post['email'])) {
                $collection = $this->collectionFactory->create();
                $collection->addFieldToFilter('email', $post['email']);
                if ($collection->getSize() > 0) {
                    $response = 'true';
                }
            }
        }
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $result->setData(['registered' => $response]);
        return $result;
    }
}