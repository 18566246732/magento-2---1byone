<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/23/18
 * Time: 4:15 AM
 */

namespace TouchShop\CategoryManager\Helper;


class FaqSendEmailHelper extends AbstractEmailContentProvider
{

    public function getContent($object)
    {
        return '网站用户刚刚提了一个问题。问题为：' . $object->getContent() .
            "\n用户邮箱：" . $object->getEmail() .
            "\nSKU:" . $object->getSku();
    }

    public function getUrlPath()
    {
        return 'support/faqs';
    }

    public function getTitle($object)
    {
        return $object->getCategories();
    }
}