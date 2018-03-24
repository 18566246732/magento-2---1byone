<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/23/18
 * Time: 12:28 AM
 */

namespace TouchShop\ReviewTool\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use TouchShop\ReviewTool\Setup\InstallSchema;

class ReviewAdvancedResourceModel extends AbstractDb
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(InstallSchema::TABLE_NAME, InstallSchema::EXTENSION_ID);
    }
}