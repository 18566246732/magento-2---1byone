<?php
/**
 * Created by PhpStorm.
 * User: baozi
 * Date: 18-4-18
 * Time: 下午1:46
 */

namespace TouchShop\Touch1byone\Controller\Account;


use Magento\Framework\App\Action\Action;

class Index extends Action
{
    public function execute() {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}