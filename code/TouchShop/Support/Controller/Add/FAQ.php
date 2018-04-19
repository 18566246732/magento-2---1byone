<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/19/18
 * Time: 12:58 AM
 */

namespace TouchShop\Support\Controller\Add;


use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\CategoryRepository;
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
    private $productRepository;
    private $categoryRepository;

    public function __construct(
        Context $context,
        Session $session,
        StoreManagerInterface $storeManager,
        FAQModelFactory $modelFactory,
        FAQResourceModel $resourceModel,
        ProductRepositoryInterface $productRepository,
        CategoryRepository $categoryRepository
    )
    {
        parent::__construct($context);
        $this->faqModelFactory = $modelFactory;
        $this->faqResourceModel = $resourceModel;
        $this->session = $session;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;

    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        $post = (array)$this->getRequest()->getPost();
        if (!empty($post)) {
            $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);

            try {
                /** @var FAQModel */
                $faqModel = $this->faqModelFactory->create();
                $faqModel->setContent($post['content'])
                    ->setProductId($post['productId'])
                    ->setCustomerId($this->session->getCustomerId())
                    ->setEmail($post['email'])
                    ->setStoreId($this->storeManager->getStore()->getId());
                $product = $this->productRepository->getById($post['productId']);
                $faqModel->setSku($product->getSku());
                $categoryIds = $product->getCategoryIds();
                $categoryNames = [];
                foreach ($categoryIds as $categoryId) {
                    $category = $this->categoryRepository->get($categoryId);
                    $categoryNames[] = $category->getName();
                }
                $faqModel->setCategories(join(',', $categoryNames));

                $this->faqResourceModel->save($faqModel);

                // Display the succes form validation message
                $this->messageManager->addSuccessMessage(
                    'Success! we will contact you as soon as possible to solve this problem'
                );
                return $result->setData(['result' => 'success', 'status_code' => 200]);
            } catch (\Exception $e) {
                return $result->setData(['result' => 'fail', 'status_code' => 500, 'error_message' => $e->getMessage()]);
            }
        }
    }
}