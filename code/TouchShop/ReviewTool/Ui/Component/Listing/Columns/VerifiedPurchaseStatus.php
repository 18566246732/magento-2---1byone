<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/29/18
 * Time: 7:00 PM
 */

namespace TouchShop\ReviewTool\Ui\Component\Listing\Columns;


use Magento\Framework\Data\OptionSourceInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class VerifiedPurchaseStatus extends Column implements OptionSourceInterface
{

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => 'Verified Purchase',
                'label' => 'Verified Purchase'
            ], [
                'value' => '',
                'label' => 'Not Verified'
            ]
        ];
    }
}