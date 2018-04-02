<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/1/18
 * Time: 5:31 AM
 */

namespace TouchShop\ReviewTool\Controller\Index;


use Magento\Catalog\Model\Product;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;

class CurrentProduct extends Action
{

    private $registry;

    public function __construct(
        Context $context,
        Registry $registry
    )
    {
        $this->registry = $registry;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $product = $this->registry->registry('current_product');
        $id = 'null';
        if ($product) {
            $id = $product->getId();
        }

        $result->setData(['id' => $id . time(), 'product' => $product]);

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /**@var Registry $registry */
        $registry = $objectManager->get(\Magento\Framework\Registry::class);
        $result->setData([
            'test' => $registry->registry('current_product'),
            'current_category' => $registry->registry('current_category')
        ]);
        return $result;
    }
}