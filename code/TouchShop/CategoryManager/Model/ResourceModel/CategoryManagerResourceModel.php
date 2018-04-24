<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/22/18
 * Time: 6:50 PM
 */

namespace TouchShop\CategoryManager\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use TouchShop\CategoryManager\Setup\InstallSchema;

class CategoryManagerResourceModel extends AbstractDb
{

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(InstallSchema::TABLE_NAME, InstallSchema::MANAGER_ID);
    }
}