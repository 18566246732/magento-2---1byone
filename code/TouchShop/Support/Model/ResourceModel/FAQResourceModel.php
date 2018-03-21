<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/20/18
 * Time: 5:51 AM
 */

namespace TouchShop\Support\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use TouchShop\Support\Setup\InstallSchema;

class FAQResourceModel extends AbstractDb
{

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(InstallSchema::TABLE_NAME, InstallSchema::FAQ_ID);
    }
}