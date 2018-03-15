<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/27/18
 * Time: 3:44 AM
 */

namespace TouchShop\Feedback\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use TouchShop\Feedback\Setup\InstallSchema;

class Complaint extends AbstractModel implements IdentityInterface
{

    const CACHE_TAG = InstallSchema::TABLE_NAME;
    protected $_cacheTag = self::CACHE_TAG;
    protected $_eventPrefix = self::CACHE_TAG;

    protected function _construct()
    {
        $this->_init(\TouchShop\Feedback\Model\ResourceModel\Complaint::class);
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