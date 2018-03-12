<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/1/18
 * Time: 1:30 AM
 */

namespace TouchShop\Complain\Controller\Adminhtml\Complaints;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\Action;
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
        $resultPage->getConfig()->getTitle()->prepend((__('Complaints')));

        return $resultPage;
    }
}