<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/12/18
 * Time: 8:15 PM
 */

namespace TouchShop\Refund\Ui\Component\Listing\Columns;


use Magento\Framework\Data\OptionSourceInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use TouchShop\Refund\Helper\Options;

class ReasonSelect extends Column implements OptionSourceInterface
{

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return Options::getReasons();
    }
}