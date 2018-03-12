<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/24/18
 * Time: 12:58 AM
 */

namespace TouchShop\Basic\Block;


use Magento\Framework\View\Element\Template;

class CarouselBasic extends Template
{
    const FULL_SCREEN = 'full_screen';
    const IMAGES = 'images';

    public function safeGetData($key, $index = null, $default = null)
    {
        $result = $this->getData($key, $index);
        return $result ? $result : $default;
    }

    /**
     * @return string
     */
    public function getImages()
    {
        return $this->safeGetData(self::IMAGES, null, []);
    }

    /**
     * @return bool
     */
    public function isFullScreen()
    {
        return $this->safeGetData(self::FULL_SCREEN, null, false);
    }
}