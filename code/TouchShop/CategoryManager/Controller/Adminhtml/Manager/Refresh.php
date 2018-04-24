<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/22/18
 * Time: 7:08 PM
 */

namespace TouchShop\CategoryManager\Controller\Adminhtml\Manager;


use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\StoreManagerInterface;
use TouchShop\CategoryManager\Model\CategoryManagerFactory;
use TouchShop\CategoryManager\Model\ResourceModel\CategoryManagerResourceModel;
use TouchShop\CategoryManager\Model\ResourceModel\Manager\CategoryManagerCollectionFactory;
use TouchShop\ProductTool\Helper\CategoryHelper;

class Refresh extends Action
{
    private $helper;
    private $resourceModel;
    private $collection;
    private $factory;
    private $storeManager;

    public function __construct(
        Action\Context $context,
        CategoryHelper $categoryHelper,
        CategoryManagerResourceModel $resourceModel,
        CategoryManagerCollectionFactory $collection,
        StoreManagerInterface $storeManager,
        CategoryManagerFactory $factory
    )
    {
        parent::__construct($context);
        $this->helper = $categoryHelper;
        $this->resourceModel = $resourceModel;
        $this->collection = $collection;
        $this->storeManager = $storeManager;
        $this->factory = $factory;
    }


    public function execute()
    {
        try {

            foreach ($this->helper->getCategories() as $category) {
                $id = $category['value'];
                $collection = $this->collection->create();
                $collection->addFieldToFilter('category_id', intval($id));
                if ($id != 0 && $collection->getSize() == 0) {
                    $categoryManager = $this->factory->create();
                    $store = $this->storeManager->getStore();
                    $categoryManager->setCategoryId($id)
                        ->setStoreId($store->getId())
                        ->setName($category['label'])
                        ->setStoreName($store->getName());
                    $this->resourceModel->save($categoryManager);

                }

            }
            $this->messageManager->addSuccessMessage(
                '已经同步最新的category目录。如果有删除的目录，请手动选中删除。'
            );
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());

            return $resultRedirect;

        } catch (\Exception $e) {
            //todo
        }
    }
}