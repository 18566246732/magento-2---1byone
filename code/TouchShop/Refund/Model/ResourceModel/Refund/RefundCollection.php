<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/12/18
 * Time: 6:48 PM
 */

namespace TouchShop\Refund\Model\ResourceModel\Refund;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use TouchShop\Refund\Model\Refund;
use TouchShop\Refund\Model\ResourceModel\RefundResourceModel;
use TouchShop\Refund\Setup\InstallSchema;

class RefundCollection extends AbstractCollection
{
    protected $_idFieldName = InstallSchema::REFUND_ID;
    protected $_eventPrefix = 'touch_shop_refund_refund_collection';
    protected $_eventObject = 'refund_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Refund::class, RefundResourceModel::class);
    }
}