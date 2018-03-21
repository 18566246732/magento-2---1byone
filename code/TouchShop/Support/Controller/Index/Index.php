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
//        $data = [
//            'key' => 'WT08',
//            'page_num' => 1,
//            'page_size' => 1
//        ];
        $this->registry->register('support_post', $data);
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}