<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/26/18
 * Time: 11:21 PM
 */

namespace TouchShop\Refund\Block;

use Magento\Framework\View\Element\Template;

class Refund extends Template
{
    /**
     * Retrieve form action
     *
     * @return string
     */
    public function getFormAction()
    {
        return '/refund';
    }

    public function getBaseImgUrl($imgName) {
        return $this->getBaseUrl().'pub/media/refund-exchange/'.$imgName;
    }
}