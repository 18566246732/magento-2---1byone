<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/20/18
 * Time: 5:52 AM
 */

namespace TouchShop\Support\Model\ResourceModel\FAQ;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use TouchShop\Support\Model\FAQModel;
use TouchShop\Support\Model\ResourceModel\FAQResourceModel;
use TouchShop\Support\Setup\InstallSchema;

class FAQCollection extends AbstractCollection
{
    protected $_idFieldName = InstallSchema::FAQ_ID;
    protected $_eventPrefix = 'touch_shop_faq_collection';
    protected $_eventObject = 'faq_collection';

    protected function _construct()
    {
        $this->_init(FAQModel::class, FAQResourceModel::class);
    }


}