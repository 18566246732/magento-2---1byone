<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 1/29/18
 * Time: 11:08 PM
 */

namespace TouchShop\ReviewTool\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use TouchShop\ReviewTool\Api\Data\ReviewAdvancedInterface;
use TouchShop\ReviewTool\Model\ResourceModel\ReviewAdvancedResourceModel;
use TouchShop\ReviewTool\Setup\InstallSchema;

class ReviewAdvanced extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = InstallSchema::TABLE_NAME;
    protected $_cacheTag = self::CACHE_TAG;
    protected $_eventPrefix = self::CACHE_TAG;

    protected function _construct()
    {
        $this->_init(ReviewAdvancedResourceModel::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}