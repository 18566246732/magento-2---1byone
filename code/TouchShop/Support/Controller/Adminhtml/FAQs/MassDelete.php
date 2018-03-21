<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/1/18
 * Time: 7:17 AM
 */

namespace TouchShop\Support\Controller\Adminhtml\FAQs;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use TouchShop\Support\Model\ResourceModel\FAQ\FAQCollectionFactory;

class MassDelete extends Action
{
    /** @var Filter */
    private $filter;

    /** @var FAQCollectionFactory */
    private $collectionFactory;


    public function __construct(
        Context $context,
        Filter $filter,
        FAQCollectionFactory $collectionFactory
    )
    {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        foreach ($collection as $item) {
            $item->delete();
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        return $resultRedirect;

    }
}