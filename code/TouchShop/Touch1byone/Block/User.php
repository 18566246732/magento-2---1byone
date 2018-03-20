<?php
/**
 * Created by PhpStorm.
 * User: baozi
 * Date: 18-3-19
 * Time: 下午9:43
 */

namespace TouchShop\Touch1byone\Block;


use Magento\Framework\View\Element\Template;

class User extends Template
{
    public function getImgBaseUrl($imgName)
    {
        return $this->getBaseUrl() . 'pub/media/wysiwyg/' . $imgName;
    }
}