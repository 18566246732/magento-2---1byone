<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/27/18
 * Time: 3:56 AM
 */

namespace TouchShop\Complain\Model\ResourceModel\Complaint;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use TouchShop\Complain\Model\Complaint;
use TouchShop\Complain\Setup\InstallSchema;

class Collection extends AbstractCollection
{
    protected $_idFieldName = InstallSchema::COMPLAINT_ID;
    protected $_eventPrefix = 'touch_shop_complain_complaint_collection';
    protected $_eventObject = 'complaint_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Complaint::class, \TouchShop\Complain\Model\ResourceModel\Complaint::class);
    }
}