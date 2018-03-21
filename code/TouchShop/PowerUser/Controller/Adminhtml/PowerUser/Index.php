<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/21/18
 * Time: 2:34 AM
 */

namespace TouchShop\PowerUser\Controller\Adminhtml\PowerUser;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{

    private $resultPageFactory;

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
        $resultPage->getConfig()->getTitle()->prepend((__('Power User')));

        return $resultPage;
    }
}