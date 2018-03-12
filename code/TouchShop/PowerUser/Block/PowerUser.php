<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/26/18
 * Time: 11:21 PM
 */

namespace TouchShop\PowerUser\Block;

use Magento\Framework\View\Element\Template;

class PowerUser extends Template
{
    /**
     * Retrieve form action
     *
     * @return string
     */
    public function getFormAction()
    {
        return '/poweruser';
    }

    public function getBaseImgUrl($imgName) {
        return $this->getBaseUrl().'pub/media/poweruser/'.$imgName;
    }
}