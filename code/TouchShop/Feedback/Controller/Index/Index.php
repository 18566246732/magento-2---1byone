<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/26/18
 * Time: 11:23 PM
 */

namespace TouchShop\Feedback\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\StoreManagerInterface;
use TouchShop\Feedback\Model\Complaint;
use TouchShop\Feedback\Model\ComplaintFactory;

class Index extends Action
{
    /** @var ComplaintFactory */
    private $complaintFactory;

    /** @var \TouchShop\Feedback\Model\ResourceModel\Complaint */
    private $resourceModel;
    private $storeManager;
    private $session;


    public function __construct(
        Context $context,
        ComplaintFactory $complaintFactory,
        Session $session,
        StoreManagerInterface $storeManager,
        \TouchShop\Feedback\Model\ResourceModel\Complaint $resourceModel
    )
    {
        parent::__construct($context);
        $this->complaintFactory = $complaintFactory;
        $this->resourceModel = $resourceModel;
        $this->session = $session;
        $this->storeManager = $storeManager;
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
                ->setDetail($post['detail'])
                ->setStoreId($this->storeManager->getStore()->getId());

            if ($this->session->isLoggedIn()) {
                $complaint->setCustomerId($this->session->getCustomerId());
            }

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