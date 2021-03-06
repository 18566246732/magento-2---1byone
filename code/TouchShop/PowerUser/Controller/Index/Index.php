<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/26/18
 * Time: 11:23 PM
 */

namespace TouchShop\PowerUser\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\StoreManagerInterface;
use TouchShop\PowerUser\Helper\PowerUserHelper;
use TouchShop\PowerUser\Model\PowerUserModelFactory;
use TouchShop\PowerUser\Model\ResourceModel\PowerUser\PowerUserCollection;
use TouchShop\PowerUser\Model\ResourceModel\PowerUserResourceModel;

class Index extends Action
{
    private $powerUserModelFactory;
    private $powerUserResourceModel;
    private $session;
    private $storeManger;
    private $powerUserCollection;

    public function __construct(
        Context $context,
        PowerUserModelFactory $modelFactory,
        PowerUserResourceModel $resourceModel,
        StoreManagerInterface $storeManager,
        PowerUserCollection $powerUserCollection,
        Session $session
    )
    {
        parent::__construct($context);
        $this->powerUserModelFactory = $modelFactory;
        $this->powerUserResourceModel = $resourceModel;
        $this->storeManger = $storeManager;
        $this->powerUserCollection = $powerUserCollection;
        $this->session = $session;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        $post = (array)$this->getRequest()->getPost();
        $powerUser = null;
        if (!empty($post)) {
            $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            try {
                if (isset($post['interests'])) {
                    if (isset($post['customerId'])) {
                        $customer_id = $post['customerId'];
                        $this->powerUserCollection->addFieldToFilter('customer_id', $customer_id);
                        $size = $this->powerUserCollection->getSize();
                        if ($size) {
                            $items = $this->powerUserCollection->getItems();
                            $powerUser = $items[array_keys($items)[0]];
                        }
                    }


                    if (!$powerUser) {
                        $powerUser = $this->powerUserModelFactory->create();
                    }
                    $powerUser->setInterests(PowerUserHelper::resolveInterestsToString($post['interests']))
                        ->setEmail($post['email'])
                        ->setCountry($post['country'])
                        ->setCustomerId($this->session->getCustomerId())
                        ->setStoreId($this->storeManger->getStore()->getId());
                    $this->powerUserResourceModel->save($powerUser);

                    // Display the succes form validation message
                    $this->messageManager->addSuccessMessage('done !');

                    return $result->setData(['result' => 'success', 'status_code' => 200]);
                }
            } catch (\Exception $e) {
                return $result->setData(['result' => 'fail', 'status_code' => 500, 'error_message' => $e->getMessage()]);
            }

        }
        // Render the page
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}