<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/12/18
 * Time: 11:47 PM
 */

namespace TouchShop\Refund\Controller\Adminhtml\Refund;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use TouchShop\Refund\Model\ResourceModel\Refund\RefundCollection;

class Edit extends Action
{
    private $resultPageFactory;
    private $registry;
    private $collection;

    /**
     * Edit constructor.
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $registry
     * @param RefundCollection $collection
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        RefundCollection $collection
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->registry = $registry;
        $this->collection = $collection;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
//        $resultPage->setActiveMenu('Magento_Cms::cms_page')
//            ->addBreadcrumb(__('CMS'), __('CMS'))
//            ->addBreadcrumb(__('Manage Pages'), __('Manage Pages'));
        return $resultPage;
    }


    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('refund_id');

        // 2. Initial checking
        if ($id) {
            $model = $this->collection->getItemById($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This page no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->registry->register('refund', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Complaint') : __('New Refund'),
            $id ? __('Edit Complaint') : __('New Refund')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Complaints'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('Refund'));

        return $resultPage;
    }
}