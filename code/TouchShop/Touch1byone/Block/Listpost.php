<?php
/**
 * Created by PhpStorm.
 * User: baozi
 * Date: 18-4-17
 * Time: 上午9:30
 */

namespace TouchShop\Touch1byone\Block;


class Listpost extends \Mageplaza\Blog\Block\Post\Listpost
{
    public function getBlogTitle($meta = false)
    {
        $pageTitle = $this->helperData->getConfigGeneral('name') ?: __('');
        if ($meta) {
            $title = $this->helperData->getSeoConfig('meta_title') ?: $pageTitle;

            return [$title];
        }

        return $pageTitle;
    }
}