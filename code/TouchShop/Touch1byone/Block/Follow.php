<?php
/**
 * Created by PhpStorm.
 * User: lalala
 * Date: 2/26/18
 * Time: 2:04 AM
 */

namespace TouchShop\Touch1byone\Block;


use Magento\Framework\View\Element\Template;

class Follow extends Template
{
    public function getImgBaseUrl($imgName)
    {
        return $this->getBaseUrl() . 'pub/media/follow/' . $imgName;
    }
}