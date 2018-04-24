<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/23/18
 * Time: 4:29 AM
 */

namespace TouchShop\CategoryManager\Helper;


class RefundSendEmailHelper extends AbstractEmailContentProvider
{

    public function getContent($object)
    {
        return '网站用户刚刚提交了一个退换货请求。原因是：' . $object->getReason() . "\n用户邮箱：" . $object->getEmail();
    }

    public function getUrlPath()
    {
        return 'refund/refund';
    }
}