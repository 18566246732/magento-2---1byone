<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/2/18
 * Time: 10:52 PM
 */

namespace TouchShop\ReviewTool\Controller\Adminhtml\Manager;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory = false;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Reviews Manager')));

        return $resultPage;

    }
}