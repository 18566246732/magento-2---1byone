<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/21/18
 * Time: 12:01 AM
 */

namespace TouchShop\PowerUser\Model;


use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use TouchShop\PowerUser\Model\ResourceModel\PowerUserResourceModel;
use TouchShop\PowerUser\Setup\InstallSchema;

class PowerUserModel extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = InstallSchema::TABLE_NAME;
    protected $_cacheTag = self::CACHE_TAG;
    protected $_eventPrefix = self::CACHE_TAG;

    protected function _construct()
    {
        $this->_init(PowerUserResourceModel::class);
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