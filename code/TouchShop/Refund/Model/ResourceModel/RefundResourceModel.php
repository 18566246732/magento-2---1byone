<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/12/18
 * Time: 6:46 PM
 */

namespace TouchShop\Refund\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use TouchShop\Refund\Setup\InstallSchema;

class RefundResourceModel extends AbstractDb
{

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(InstallSchema::TABLE_NAME, InstallSchema::REFUND_ID);
    }
}