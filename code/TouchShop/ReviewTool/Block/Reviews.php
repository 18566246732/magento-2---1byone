<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/6/18
 * Time: 12:39 AM
 */

namespace TouchShop\ReviewTool\Block;


use Magento\Framework\View\Element\Template;

class Reviews extends Template
{
    public function getChartData()
    {
        return [
            'Grading trend map' => [
                'data' => [
                    '1 star' => [
                        1, 2, 3, 4, 5
                    ],
                    '2 star' => [
                        5.5, 7, 3, 4, 5
                    ],
                    '3 star' => [
                        1, 2, 7, 5.5, 5
                    ],
                    '4 star' => [
                        2, 7, 3, 5.5, 5
                    ],
                    '5 star' => [
                        1.3, 5.5, 3, 4, 7
                    ],
                    'positive' => [
                        3, 10, 9, 7.4, 2
                    ],
                    'critical' => [
                        0.9, 8.7, 3.3, 10, 5
                    ]
                ],
                'y' => ['3-10', '3-11', '3-12', '3-13', '3-14']
            ],
            'star' => [
                'data' => [
                    '1 star' => [
                        1, 2, 3, 4, 5
                    ],
                    '2 star' => [
                        5.5, 7, 3, 4, 5
                    ],
                    '3 star' => [
                        1, 2, 7, 5.5, 5
                    ],
                    '4 star' => [
                        2, 7, 3, 5.5, 5
                    ],
                    '5 star' => [
                        1.3, 5.5, 3, 4, 7
                    ]
                ],
                'y' => ['3-10', '3-11', '3-12', '3-13', '3-14']
            ],
            'star ratio' => [
                'data' => [
                    ['1 star', 10],
                    ['2 star', 10],
                    ['3 star', 20],
                    ['4 star', 50],
                    ['5 star', 10],
                ],
                'y' => ['3-10', '3-11', '3-12', '3-13', '3-14']
            ]
        ];
    }
}