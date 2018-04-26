<?php
/**
 * Created by PhpStorm.
 * User: baozi
 * Date: 18-4-26
 * Time: 上午10:29
 */

namespace TouchShop\Touch1byone\Plugin\Block;


class ModifyRelatedTitle
{
    public function afterSetTabTitle($subject)
    {

        $title = 'Related';

        $subject->setTitle($title);
    }
}