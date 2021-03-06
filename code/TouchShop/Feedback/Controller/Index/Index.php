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
use TouchShop\CategoryManager\Helper\FeedbackSendEmailHelper;
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
    private $helper;


    public function __construct(
        Context $context,
        ComplaintFactory $complaintFactory,
        Session $session,
        StoreManagerInterface $storeManager,
        FeedbackSendEmailHelper $helper,
        \TouchShop\Feedback\Model\ResourceModel\Complaint $resourceModel
    )
    {
        parent::__construct($context);
        $this->complaintFactory = $complaintFactory;
        $this->resourceModel = $resourceModel;
        $this->session = $session;
        $this->helper = $helper;
        $this->storeManager = $storeManager;
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|null
     * @throws \Exception
     */
    public function execute()
    {
        $post = (array)$this->getRequest()->getPost();
        if (!empty($post)) {

            $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);

            try {
                /** @var Complaint */
                $complaint = $this->complaintFactory->create($post);
                $complaint->setEmail($post['email'])
                    ->setOrder($post['order'])
                    ->setDetail($post['detail'])
                    ->setCategoryId($post['categoryId'])
                    ->setStoreId($this->storeManager->getStore()->getId());

                if ($this->session->isLoggedIn()) {
                    $complaint->setCustomerId($this->session->getCustomerId());
                }

                $this->resourceModel->save($complaint);

                // Display the succes form validation message
                $this->messageManager->addSuccessMessage(
                    'Thank you for you feedback, we will contact you as soon as possible to solve this problem'
                );

                $this->helper->sendEmail($complaint);

                return $result->setData(['result' => 'success', 'status_code' => 200]);
            } catch (\Exception $e) {
                return $result->setData(['result' => 'fail', 'status_code' => 500, 'error_message' => $e->getMessage()]);
            }
        }
        // Render the page
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}