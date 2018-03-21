<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/20/18
 * Time: 5:47 AM
 */

namespace TouchShop\Support\Model;


use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use TouchShop\Support\Model\ResourceModel\FAQResourceModel;
use TouchShop\Support\Setup\InstallSchema;

class FAQModel extends AbstractModel implements IdentityInterface
{

    const CACHE_TAG = InstallSchema::TABLE_NAME;
    protected $_cacheTag = self::CACHE_TAG;
    protected $_eventPrefix = self::CACHE_TAG;

    protected function _construct()
    {
        $this->_init(FAQResourceModel::class);
    }


    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}