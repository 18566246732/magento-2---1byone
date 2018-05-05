<?php
/**
 * Created by PhpStorm.
 * User: baozi
 * Date: 18-5-5
 * Time: 上午10:19
 */

namespace TouchShop\Touch1byone\Block;


class Forgotpassword extends \Magento\Customer\Block\Account\Forgotpassword
{
    protected function _prepareLayout()
    {
        return $this;
    }

    public function getLoginUrl()
    {
        return $this->customerUrl->getLoginUrl();
    }
}