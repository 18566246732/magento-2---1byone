<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/23/18
 * Time: 4:34 AM
 */

namespace TouchShop\CategoryManager\Helper;

// 暂时不用
class PowerUserSendEmailHelper extends AbstractEmailContentProvider
{

    public function getContent($object)
    {
        return '网站用户刚刚新增了超级用户。兴趣列表为：' . $object->getInterests() . "\n用户邮箱：" . $object->getEmail();
    }

    public function getUrlPath()
    {
        return 'refund/refund';
    }
}