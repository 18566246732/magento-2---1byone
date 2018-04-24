<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/22/18
 * Time: 11:52 PM
 */

namespace TouchShop\CategoryManager\Controller\Adminhtml\Manager;


use Magento\Backend\App\Action;
use TouchShop\CategoryManager\Model\ResourceModel\Manager\CategoryManagerCollection;

class Save extends Action
{
    private $context;
    private $collection;

    public function __construct(
        Action\Context $context,
        CategoryManagerCollection $collection
    )
    {
        $this->context = $context;
        $this->collection = $collection;
        parent::__construct($context);
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $id = $this->getRequest()->getParam('manager_id');
        if ($data) {
            $model = $this->collection->getItemById($id);
            $model->setData($data);
            $model->save();
        }
        return $resultRedirect->setPath('category_manager/');
    }
}