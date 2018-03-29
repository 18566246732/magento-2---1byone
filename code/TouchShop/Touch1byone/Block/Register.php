<?php
/**
 * Created by PhpStorm.
 * User: baozi
 * Date: 18-3-28
 * Time: 下午5:35
 */

namespace TouchShop\Touch1byone\Block;


class Register extends \Magento\Customer\Block\Form\Register
{
    protected function _prepareLayout()
    {
        return $this;
    }
}