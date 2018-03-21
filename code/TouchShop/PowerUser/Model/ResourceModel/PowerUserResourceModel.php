<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/20/18
 * Time: 11:52 PM
 */

namespace TouchShop\PowerUser\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use TouchShop\PowerUser\Setup\InstallSchema;

class PowerUserResourceModel extends AbstractDb
{

    protected function _construct()
    {
        $this->_init(InstallSchema::TABLE_NAME, InstallSchema::POWER_USER_ID);
    }
}