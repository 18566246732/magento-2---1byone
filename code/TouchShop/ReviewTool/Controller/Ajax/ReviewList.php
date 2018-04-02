<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/1/18
 * Time: 9:02 PM
 */

namespace TouchShop\ReviewTool\Controller\Ajax;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;

class ReviewList extends Action
{
    /** @var Registry */
    private $registry;

    public function __construct(
        Registry $registry,
        Context $context
    )
    {
        $this->registry = $registry;
        parent::__construct($context);
    }


    public function execute()
    {
        $post = (array)$this->getRequest()->getPost();
        $this->registry->register('postData', $post);
        $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
        return $resultLayout;
    }
}