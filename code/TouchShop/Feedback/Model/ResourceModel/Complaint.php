<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/27/18
 * Time: 3:54 AM
 */

namespace TouchShop\Feedback\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use TouchShop\Feedback\Setup\InstallSchema;

class Complaint extends AbstractDb
{

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(InstallSchema::TABLE_NAME, InstallSchema::COMPLAINT_ID);
    }
}