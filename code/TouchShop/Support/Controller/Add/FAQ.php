<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/19/18
 * Time: 12:58 AM
 */

namespace TouchShop\Support\Controller\Add;


use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use TouchShop\Support\Model\FAQModel;
use TouchShop\Support\Model\FAQModelFactory;
use TouchShop\Support\Model\ResourceModel\FAQResourceModel;

class FAQ extends Action
{
    /** @var FAQModelFactory */
    private $faqModelFactory;

    /** @var FAQResourceModel */
    private $faqResourceModel;
    private $storeManager;
    private $session;
    private $registry;

    public function __construct(
        Context $context,
        Session $session,
        StoreManagerInterface $storeManager,
        FAQModelFactory $modelFactory,
        FAQResourceModel $resourceModel,
        Registry $registry
    )
    {
        parent::__construct($context);
        $this->faqModelFactory = $modelFactory;
        $this->faqResourceModel = $resourceModel;
        $this->session = $session;
        $this->storeManager = $storeManager;
        $this->registry = $registry;

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
            /** @var FAQModel */
            $faqModel = $this->faqModelFactory->create();
            $faqModel->setContent($post['content'])
                ->setProductId($this->registry->registry('current_product'))
                ->setCustomerId($this->session->getCustomerId())
                ->setEmail($post['email'])
                ->setStoreId($this->storeManager->getStore()->getId());

            $this->faqResourceModel->save($faqModel);

            // Display the succes form validation message
            $this->messageManager->addSuccessMessage(
                'Success! we will contact you as soon as possible to solve this problem'
            );

            // Redirect to your form page (or anywhere you want...)
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());

            return $resultRedirect;
        }
    }
}