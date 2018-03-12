<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/26/18
 * Time: 11:23 PM
 */

namespace TouchShop\Sales\Controller\Index;

use Magento\Framework\App\Action\Action;

class Index extends Action
{

    /**
     * Contact action
     *
     */
    public function execute()
    {
        // Render the page
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}