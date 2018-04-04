<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/4/18
 * Time: 12:33 AM
 */

namespace TouchShop\ReviewTool\Controller\Adminhtml\Reviews;


use Magento\Backend\App\Action;
use Magento\Review\Model\ResourceModel\Review;
use TouchShop\ReviewTool\Model\ResourceModel\ReviewAdvanced\ReviewAdvancedCollection;
use Magento\Review\Model\ReviewFactory;
use TouchShop\ReviewTool\Ui\Component\Listing\Columns\Status;

class Save extends Action
{
    private $context;
    private $collection;
    private $factory;
    private $resource;

    public function __construct(
        Action\Context $context,
        Review $resource,
        ReviewFactory $factory,
        ReviewAdvancedCollection $collection
    )
    {
        $this->context = $context;
        $this->collection = $collection;
        $this->factory = $factory;
        $this->resource = $resource;
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
        $id = $this->getRequest()->getParam('extension_id');
        if ($data) {
            $model = $this->collection->getItemById($id);
            $model->setData($data);
            $model->save();

            $review = $this->factory->create();
            $this->resource->load($review, $model->getReviewId());
            $review->setStatusId(Status::getReviewStatus($model->getStatus()));
            $this->resource->save($review);

        }
        return $resultRedirect->setPath('reviews/extension');
    }
}