<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/19/18
 * Time: 12:58 AM
 */

namespace TouchShop\Support\Controller\Add;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use TouchShop\Support\Model\FAQModel;
use TouchShop\Support\Model\FAQModelFactory;
use TouchShop\Support\Model\ResourceModel\FAQResourceModel;

class FAQ extends Action
{
    /** @var FAQModelFactory */
    private $faqModelFactory;

    /** @var FAQResourceModel */
    private $faqResourceModel;

    public function __construct(
        Context $context,
        FAQModelFactory $modelFactory,
        FAQResourceModel $resourceModel
    )
    {
        parent::__construct($context);
        $this->faqModelFactory = $modelFactory;
        $this->faqResourceModel = $resourceModel;
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute()
    {
        $post = (array)$this->getRequest()->getPost();
        $post = [
            'content' => 'It is an awesome question!',
            'productId' => 1801
        ];
        if (!empty($post)) {
            /** @var FAQModel */
            $faqModel = $this->faqModelFactory->create();
            $faqModel->setContent($post['content'])
                ->setProductId($post['productId']);

            $this->faqResourceModel->save($faqModel);

            // Display the succes form validation message
            $this->messageManager->addSuccessMessage(
                'Thank you for you feedback, we will contact you as soon as possible to solve this problem'
            );

            // Redirect to your form page (or anywhere you want...)
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());

            return $resultRedirect;
        }
    }
}