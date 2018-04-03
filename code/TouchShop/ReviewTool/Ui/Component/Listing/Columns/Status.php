<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/3/18
 * Time: 5:03 AM
 */

namespace TouchShop\ReviewTool\Ui\Component\Listing\Columns;


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
        return ['Pending', 'Approved', 'Closed'];
    }
}