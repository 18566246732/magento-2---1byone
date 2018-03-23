<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/26/18
 * Time: 5:09 PM
 */

namespace TouchShop\Feedback\Block;

use Magento\Framework\View\Element\Template;

class Complain extends Template
{
    /**
     * Retrieve form action
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getBaseUrl() . '/feedback';
    }
}