<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/29/18
 * Time: 6:04 PM
 */

namespace TouchShop\ReviewTool\Controller\Adminhtml\Extension;


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
        $resultPage->getConfig()->getTitle()->prepend((__('Reviews')));

        return $resultPage;
    }
}