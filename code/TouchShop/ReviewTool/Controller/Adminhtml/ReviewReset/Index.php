<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/26/18
 * Time: 2:48 AM
 */

namespace TouchShop\ReviewTool\Controller\Adminhtml\ReviewReset;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use TouchShop\Basic\Helper\HttpHelper;

class Index extends Action
{

    protected $resultPageFactory = false;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        HttpHelper::get('http://192.168.0.153:8080/resetReviewFlag');
    }
}
