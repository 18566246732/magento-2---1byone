<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/14/18
 * Time: 7:07 PM
 */

namespace TouchShop\Touch1byone\Plugin\Block;


class WysiwygConfig
{
    public function afterGetConfig($subject, \Magento\Framework\DataObject $config)
    {
        $config->addData([
            'add_directives' => true,
        ]);

        return $config;
    }
}