<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/26/18
 * Time: 11:23 PM
 */

namespace TouchShop\Complain\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use TouchShop\Complain\Model\Complaint;
use TouchShop\Complain\Model\ComplaintFactory;

class Index extends Action
{
    /** @var ComplaintFactory */
    private $complaintFactory;

    /** @var \TouchShop\Complain\Model\ResourceModel\Complaint */
    private $resourceModel;


    public function __construct(
        Context $context,
        ComplaintFactory $complaintFactory,
        \TouchShop\Complain\Model\ResourceModel\Complaint $resourceModel
    )
    {
        parent::__construct($context);
        $this->complaintFactory = $complaintFactory;
        $this->resourceModel = $resourceModel;
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|null
     * @throws \Exception
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute()
    {
        $post = (array)$this->getRequest()->getPost();
        if (!empty($post)) {

            /** @var Complaint */
            $complaint = $this->complaintFactory->create($post);
            $complaint->setEmail($post['email'])
                ->setName($post['name'])
                ->setOrder($post['order'])
                ->setDetail($post['detail']);

            $this->resourceModel->save($complaint);

            // Display the succes form validation message
            $this->messageManager->addSuccessMessage(
                'Thank you for you feedback, we will contact you as soon as possible to solve this problem'
            );

            // Redirect to your form page (or anywhere you want...)
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());

            return $resultRedirect;
        }
        // Render the page
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}