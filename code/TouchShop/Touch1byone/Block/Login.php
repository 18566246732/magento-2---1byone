<?php
/**
 * Created by PhpStorm.
 * User: baozi
 * Date: 18-3-28
 * Time: 下午5:29
 */

namespace TouchShop\Touch1byone\Block;


class Login extends \Magento\Customer\Block\Form\Login
{
    protected function _prepareLayout()
    {
        return $this;
    }
}