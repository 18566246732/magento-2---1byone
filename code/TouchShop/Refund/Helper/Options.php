<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/13/18
 * Time: 12:56 AM
 */

namespace TouchShop\Refund\Helper;


class Options
{
    const STATUS = 'status';
    const REASON = 'reason';
    const STATE = 'state';
    const TYPE = 'type';
    const COUNTRY = 'country';

    const OPTIONS = [
        self::STATUS => ['Pending', 'Processing', 'Closed'],
        self::REASON => [
            'Danged Upon Arrival',
            'Defective',
            'Sent Wrong Item',
            'Ordered Wrong Item',
            'No Larger Need',
            'Others'
        ],
        self::TYPE => [
            'Refund',
            'Exchange'
        ],
        self::COUNTRY => ['United States'],
        self::STATE => [
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
        ]
    ];


    private static function getOptions($key)
    {
        $items = self::OPTIONS[$key];
        $result = [];
        foreach ($items as $item) {
            $result[] = [
                'value' => $item,
                'label' => $item
            ];
        }
        return $result;
    }

    public static function getReasons()
    {
        return self::getOptions(self::REASON);
    }

    public static function getStates()
    {
        return self::getOptions(self::STATE);
    }

    public static function getStatus()
    {
        return self::getOptions(self::STATUS);
    }

    public static function getTypes()
    {
        return self::getOptions(self::TYPE);
    }

    public static function getCountries()
    {
        return self::getOptions(self::COUNTRY);
    }
}