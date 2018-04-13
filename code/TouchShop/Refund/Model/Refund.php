<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/12/18
 * Time: 6:45 PM
 */

namespace TouchShop\Refund\Model;


use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use TouchShop\Refund\Model\ResourceModel\RefundResourceModel;
use TouchShop\Refund\Setup\InstallSchema;

class Refund extends AbstractModel implements IdentityInterface
{

    const CACHE_TAG = InstallSchema::TABLE_NAME;
    protected $_cacheTag = self::CACHE_TAG;
    protected $_eventPrefix = self::CACHE_TAG;

    protected function _construct()
    {
        $this->_init(RefundResourceModel::class);
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