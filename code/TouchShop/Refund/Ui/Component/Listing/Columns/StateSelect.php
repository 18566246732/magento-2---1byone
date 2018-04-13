<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/12/18
 * Time: 8:32 PM
 */

namespace TouchShop\Refund\Ui\Component\Listing\Columns;


use Magento\Framework\Data\OptionSourceInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class StateSelect extends Column implements OptionSourceInterface
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
        return [
            "Alabama",
            "Alaska",
            "Arizona",
            "Arkansas",
            "California",
            "Colorado",
            "Connecticut",
            "Delaware",
            "District of Columbia",
            "Florida",
            "Georgia",
            "Hawaii",
            "Idaho",
            "Illinois",
            "Indiana",
            "Iowa",
            "Kansas",
            "Kentucky",
            "Louisiana",
            "Maine",
            "Maryland",
            "Massachusetts",
            "Michigan",
            "Minnesota",
            "Mississippi",
            "Missouri",
            "Montana",
            "Nebraska",
            "Nevada",
            "New Hampshire",
            "New Jersey",
            "New Mexico",
            "New York",
            "North Carolina",
            "North Dakota",
            "Ohio",
            "Oklahoma",
            "Oregon",
            "Pennsylvania",
            "Rhode Island",
            "South Carolina",
            "South Dakota",
            "Tennessee",
            "Texas",
            "Utah",
            "Vermont",
            "Virginia",
            "Washington",
            "West Virginia",
            "Wisconsin",
            "Wyoming"
        ];
    }
}