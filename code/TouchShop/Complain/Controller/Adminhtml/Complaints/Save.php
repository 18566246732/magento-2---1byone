<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/7/18
 * Time: 1:01 AM
 */

namespace TouchShop\Complain\Controller\Adminhtml\Complaints;


use Magento\Backend\App\Action;
use TouchShop\Complain\Model\ResourceModel\Complaint\Collection;

class Save extends Action
{
    private $context;
    private $collection;

    public function __construct(
        Action\Context $context,
        Collection $collection
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
        $id = $this->getRequest()->getParam('complaint_id');
        if ($data) {
            $model = $this->collection->getItemById($id);
            $model->setData($data);
            $model->save();
        }
        return $resultRedirect->setPath('touchshop_complain/complaints');
    }
}