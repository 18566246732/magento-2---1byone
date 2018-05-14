<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/23/18
 * Time: 12:35 AM
 */

namespace TouchShop\CategoryManager\Helper;


class FeedbackSendEmailHelper extends AbstractEmailContentProvider
{


    public function getContent($object)
    {
        return '网站用户刚刚提交了一个反馈信息，内容是：' . $object->getDetail() .
            "\n用户邮箱：" . $object->getEmail() .
            "\norder:" . $object->getOrder();
    }

    public function getUrlPath()
    {
        return 'feedback';
    }

    public function getTitle($object)
    {
        $categoryId = $object->getCategoryId();
        return $this->get_category_name($categoryId);
    }
}