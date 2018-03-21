<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/20/18
 * Time: 10:59 PM
 */

namespace TouchShop\PowerUser\Helper;


class PowerUserHelper
{
    const POWER_USER_CUSTOMER_GROUP_ID = 4;
    const SEPARATOR = ',';

    public static function resolveInterestsToString($interests)
    {
        return join(self::SEPARATOR, $interests);

    }

    public static function resolveInterestsToArray($str)
    {
        return explode(self::SEPARATOR, $str);
    }
}