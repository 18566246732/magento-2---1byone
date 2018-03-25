<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/19/18
 * Time: 3:57 AM
 */

namespace TouchShop\Touch1byone\Plugin\Block;


//class Author extends \Mageplaza\Blog\Model\ResourceModel\Author
//{
//    /**
//     * @inheritdoc
//     */
//    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
//    {
//        $object->setUrlKey(
//            $this->helperData->generateUrlKey($this, $object, $object->getUrlKey() ?: $object->getName())
//        );
//
//        if (!$object->isObjectNew()) {
//            $object->setUpdatedAt(\Zend_Date::now('en_US'));
//        }
//
//        return $this;
//    }
//
//}