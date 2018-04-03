<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/30/18
 * Time: 11:39 PM
 */

namespace TouchShop\ReviewTool\Controller\Adminhtml\Reviews;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Review\Model\ResourceModel\Review;
use Magento\Review\Model\ReviewFactory;
use Magento\Ui\Component\MassAction\Filter;
use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use TouchShop\ReviewTool\Model\ResourceModel\ReviewAdvanced\ReviewAdvancedCollectionFactory;

class MassDelete extends Action
{

    /** @var Filter */
    private $filter;

    /** @var ReviewAdvancedCollectionFactory */
    private $collectionFactory;

    /** @var Review */
    private $review;

    /** @var ReviewFactory */
    private $reviewFactory;


    public function __construct(
        Context $context,
        Filter $filter,
        Review $reviewResourceModel,
        ReviewFactory $reviewFactory,
        ReviewAdvancedCollectionFactory $collectionFactory
    )
    {
        parent::__construct($context);
        $this->filter = $filter;
        $this->review = $reviewResourceModel;
        $this->reviewFactory = $reviewFactory;
        $this->collectionFactory = $collectionFactory;
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        foreach ($collection as $item) {
            $item->delete();
            $entity = $this->reviewFactory->create();
            $this->review->load($entity, $item->getReviewId());
            $this->review->delete($entity);
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        return $resultRedirect;

    }
}