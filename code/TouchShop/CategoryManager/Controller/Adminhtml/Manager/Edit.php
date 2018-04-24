<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/22/18
 * Time: 11:31 PM
 */

namespace TouchShop\CategoryManager\Controller\Adminhtml\Manager;


use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use TouchShop\CategoryManager\Model\ResourceModel\Manager\CategoryManagerCollection;

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
     * @param CategoryManagerCollection $collection
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        CategoryManagerCollection $collection
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
        $id = $this->getRequest()->getParam('manager_id');

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

        $this->registry->register('manager', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit') : __('New'),
            $id ? __('Edit') : __('New')
        );

        return $resultPage;
    }
}