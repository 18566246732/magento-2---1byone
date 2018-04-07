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
use TouchShop\PowerUser\Helper\PowerUserHelper;
use TouchShop\PowerUser\Model\PowerUserModelFactory;
use TouchShop\PowerUser\Model\ResourceModel\PowerUserResourceModel;

class Index extends Action
{
    private $powerUserModelFactory;
    private $powerUserResourceModel;
    private $session;

    public function __construct(
        Context $context,
        PowerUserModelFactory $modelFactory,
        PowerUserResourceModel $resourceModel,
        Session $session
    )
    {
        parent::__construct($context);
        $this->powerUserModelFactory = $modelFactory;
        $this->powerUserResourceModel = $resourceModel;
        $this->session = $session;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute()
    {
        $post = (array)$this->getRequest()->getPost();
        if (!empty($post)) {
            if (isset($post['interests'])) {

                $powerUser = $this->powerUserModelFactory->create();
                $powerUser->setInterests(PowerUserHelper::resolveInterestsToString($post['interests']))
                    ->setEmail($post['email'])
                    ->setCustomerId($this->session->getCustomerId());
                $this->powerUserResourceModel->save($powerUser);

                // Display the succes form validation message
                $this->messageManager->addSuccessMessage('done !');

                // Redirect to your form page (or anywhere you want...)
                $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setUrl($this->_redirect->getRefererUrl());

                return $resultRedirect;
            }

        }
        // Render the page
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}