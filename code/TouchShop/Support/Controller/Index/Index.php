<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/19/18
 * Time: 1:05 AM
 */

namespace TouchShop\Support\Controller\Index;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;

class Index extends Action
{
    /**@var Registry */
    private $registry;

    public function __construct(
        Context $context,
        Registry $registry
    )
    {
        $this->registry = $registry;
        parent::__construct($context);
    }


    public function execute()
    {
        $data = (array)$this->getRequest()->getPost();
        if (empty($data)) {
            $data = [
                'key' => '',
                'page_num' => 1,
                'page_size' => 8

            ];
        } else {
            $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $result->setData($data);
            return $result;
        }
        $this->registry->register('support_post', $data);
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}