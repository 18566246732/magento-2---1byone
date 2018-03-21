<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/21/18
 * Time: 12:04 AM
 */

namespace TouchShop\PowerUser\Model\ResourceModel\PowerUser;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use TouchShop\PowerUser\Model\PowerUserModel;
use TouchShop\PowerUser\Model\ResourceModel\PowerUserResourceModel;
use TouchShop\PowerUser\Setup\InstallSchema;

class PowerUserCollection extends AbstractCollection
{
    protected $_idFieldName = InstallSchema::POWER_USER_ID;
    protected $_eventPrefix = 'touch_shop_power_user_collection';
    protected $_eventObject = 'power_user_collection';

    protected function _construct()
    {
        $this->_init(PowerUserModel::class, PowerUserResourceModel::class);
    }
}