<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/23/18
 * Time: 12:39 AM
 */

namespace TouchShop\ReviewTool\Model\ResourceModel\ReviewAdvanced;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use TouchShop\ReviewTool\Model\ResourceModel\ReviewAdvancedResourceModel;
use TouchShop\ReviewTool\Model\ReviewAdvanced;
use TouchShop\ReviewTool\Setup\InstallSchema;

class ReviewAdvancedCollection extends AbstractCollection
{
    protected $_idFieldName = InstallSchema::EXTENSION_ID;
    protected $_eventPrefix = 'touch_shop_review_extension_collection';
    protected $_eventObject = 'review_extension_collection';

    protected function _construct()
    {
        $this->_init(ReviewAdvanced::class, ReviewAdvancedResourceModel::class);
    }
}