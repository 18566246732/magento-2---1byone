<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/22/18
 * Time: 6:56 PM
 */

namespace TouchShop\CategoryManager\Controller\Adminhtml\Manager;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use TouchShop\CategoryManager\Model\ResourceModel\Manager\CategoryManagerCollectionFactory;

class MassDelete extends Action
{
    /** @var Filter */
    private $filter;

    /** @var CategoryManagerCollectionFactory */
    private $collectionFactory;


    public function __construct(
        Context $context,
        Filter $filter,
        CategoryManagerCollectionFactory $collectionFactory
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