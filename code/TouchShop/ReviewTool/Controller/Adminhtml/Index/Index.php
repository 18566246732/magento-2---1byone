<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/6/18
 * Time: 12:28 AM
 */

namespace TouchShop\ReviewTool\Controller\Adminhtml\Index;


use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action\Context;

class Index extends Action
{

    private $resultPageFactory;
    private $registry;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $registry
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->registry = $registry;
        parent::__construct($context);
    }

    public function execute()
    {
        $post = (array)$this->getRequest()->getPost();
        $this->registry->register('postData', $post);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Reviews Report')));
        return $resultPage;
    }
}