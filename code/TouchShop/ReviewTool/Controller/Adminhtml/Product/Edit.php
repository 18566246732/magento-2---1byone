<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/3/18
 * Time: 10:39 PM
 */

namespace TouchShop\ReviewTool\Controller\Adminhtml\Product;


use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use TouchShop\ReviewTool\Model\ResourceModel\ReviewAdvanced\ReviewAdvancedCollection;

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
     * @param ReviewAdvancedCollection $collection
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        ReviewAdvancedCollection $collection
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
        return $resultPage;
    }


    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('extension_id');

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

        $this->registry->register('review', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Review') : __('New Review'),
            $id ? __('Edit Review') : __('New Review')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Review'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('Review'));
        return $resultPage;
    }
}