<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/26/18
 * Time: 11:23 PM
 */

namespace TouchShop\Refund\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\StoreManagerInterface;
use TouchShop\CategoryManager\Helper\RefundSendEmailHelper;
use TouchShop\Refund\Model\RefundFactory;
use TouchShop\Refund\Model\ResourceModel\RefundResourceModel;

class Index extends Action
{
    private $storeManager;
    private $refundFactory;
    private $session;
    private $refundResourceModel;
    private $helper;

    public function __construct(
        RefundFactory $refundFactory,
        RefundResourceModel $resourceModel,
        StoreManagerInterface $storeManager,
        Session $session,
        RefundSendEmailHelper $helper,
        Context $context
    )
    {
        parent::__construct($context);
        $this->storeManager = $storeManager;
        $this->refundFactory = $refundFactory;
        $this->session = $session;
        $this->helper = $helper;
        $this->refundResourceModel = $resourceModel;
    }


    /**
     * Contact action
     *
     */
    public function execute()
    {
        $post = (array)$this->getRequest()->getPost();

        if (!empty($post)) {
            $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);

            try {
                $refund = $this->refundFactory->create();
                $type = $post['type'];
                $refund->setEmail($post['email'])
                    ->setReason($post['reason'])
                    ->setCategoryId($post['categoryId'])
                    ->setOrder($post['order'])
                    ->setIssue($post['issue'])
                    ->setStoreId($this->storeManager->getStore()->getId())
                    ->setType($type);
                if ($type == 'Exchange') {
                    $refund->setAddress($post['address'])
                        ->setState($post['state'])
                        ->setPostalCode($post['postalCode'])
                        ->setCountry($post['country'])
                        ->setPhone($post['phone']);
                }

                if ($this->session->isLoggedIn()) {
                    $refund->setCustomerId($this->session->getCustomerId());
                }

                $this->refundResourceModel->save($refund);

                $this->helper->sendEmail($refund);

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