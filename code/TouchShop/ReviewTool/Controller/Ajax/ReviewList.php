<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/1/18
 * Time: 9:02 PM
 */

namespace TouchShop\ReviewTool\Controller\Ajax;


use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class ReviewList extends Action
{
    public function execute()
    {
        //$productId = (int)$this->getRequest()->getParam('id');
        //todo set registry
        $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
        return $resultLayout;
    }
}