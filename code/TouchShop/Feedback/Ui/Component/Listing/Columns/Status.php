<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/1/18
 * Time: 7:54 AM
 */

namespace TouchShop\Feedback\Ui\Component\Listing\Columns;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Status extends Column implements OptionSourceInterface
{

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $result = [];
        foreach ($this->getStatus() as $item) {
            $result[] = ['value' => $item, 'label' => $item];
        }

        return $result;
    }

    private function getStatus()
    {
        return ['Pending', 'Processing', 'Closed'];
    }
}