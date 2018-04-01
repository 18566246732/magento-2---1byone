<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/1/18
 * Time: 5:31 AM
 */

namespace TouchShop\ReviewTool\Controller\Index;


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
        $result->setData(['id' => $product->getId()]);
        return $result;
    }
}