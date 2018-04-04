<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/3/18
 * Time: 5:03 AM
 */

namespace TouchShop\ReviewTool\Ui\Component\Listing\Columns;


use Magento\Framework\Data\OptionSourceInterface;
use Magento\Review\Model\Review;
use Magento\Ui\Component\Listing\Columns\Column;

class Status extends Column implements OptionSourceInterface
{

    const PENDING = 'Pending';
    const APPROVED = 'Approved';
    const CLOSED = 'Closed';

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
        return [self::PENDING, self::APPROVED, self::CLOSED];
    }

    public static function getReviewStatus($status)
    {
        if ($status === self::CLOSED) {
            return Review::STATUS_NOT_APPROVED;
        } elseif ($status == self::PENDING) {
            return Review::STATUS_PENDING;
        } else {
            return Review::STATUS_APPROVED;
        }
    }
}