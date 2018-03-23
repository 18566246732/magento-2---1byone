<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/22/18
 * Time: 8:12 PM
 */

namespace TouchShop\ReviewTool\Cron;


use TouchShop\Basic\Helper\HttpHelper;

class SyncReviews
{
    public function execute()
    {
        HttpHelper::post('', []);
    }
}