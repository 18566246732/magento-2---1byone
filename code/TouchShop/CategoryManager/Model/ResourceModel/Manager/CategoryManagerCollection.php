<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/22/18
 * Time: 6:52 PM
 */

namespace TouchShop\CategoryManager\Model\ResourceModel\Manager;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use TouchShop\CategoryManager\Model\CategoryManager;
use TouchShop\CategoryManager\Model\ResourceModel\CategoryManagerResourceModel;
use TouchShop\CategoryManager\Setup\InstallSchema;

class CategoryManagerCollection extends AbstractCollection
{
    protected $_idFieldName = InstallSchema::MANAGER_ID;
    protected $_eventPrefix = 'touch_shop_category_manager_collection';
    protected $_eventObject = 'category_manager_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(CategoryManager::class, CategoryManagerResourceModel::class);
    }
}