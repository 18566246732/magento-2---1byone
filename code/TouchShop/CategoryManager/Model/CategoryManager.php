<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/22/18
 * Time: 6:48 PM
 */

namespace TouchShop\CategoryManager\Model;


use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use TouchShop\CategoryManager\Model\ResourceModel\CategoryManagerResourceModel;
use TouchShop\CategoryManager\Setup\InstallSchema;

class CategoryManager extends AbstractModel implements IdentityInterface
{

    const CACHE_TAG = InstallSchema::TABLE_NAME;
    protected $_cacheTag = self::CACHE_TAG;
    protected $_eventPrefix = self::CACHE_TAG;

    protected function _construct()
    {
        $this->_init(CategoryManagerResourceModel::class);
    }


    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }


}