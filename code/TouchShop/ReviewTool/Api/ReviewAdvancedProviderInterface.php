<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 1/29/18
 * Time: 6:32 PM
 */

namespace TouchShop\ReviewTool\Api;

use TouchShop\ReviewTool\Api\Data\ReviewAdvancedInterface;

interface ReviewAdvancedProviderInterface
{
    /**
     * @param $reviewId
     * @return ReviewAdvancedInterface
     */
    public function getReviewAdvanced($reviewId);
}