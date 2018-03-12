<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 1/29/18
 * Time: 6:34 PM
 */

namespace TouchShop\ReviewTool\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;


interface ReviewAdvancedInterface extends ExtensibleDataInterface
{
    const EXTENSION_ID = 'extension_id';
    const REVIEW_ID = 'review_id';
    const VERIFIED_PURCHASE = 'verified_purchase';
    const HELPFUL = 'helpful';
    const ORIGIN = 'origin';
    const TARGET_ID = 'target_id';
    const TOP_INDEX = 'top_index';
    const RESPONSE = 'response';

    /**
     * @return int
     */
    public function getExtensionId();

    /**
     * @param int $extensionId
     * @return self
     */
    public function setExtensionId($extensionId);

    /**
     * @return int
     */
    public function getReviewId();

    /**
     * @param int $reviewId
     * @return self
     */
    public function setReviewId($reviewId);

    /**
     * @return string
     */
    public function getVerifiedPurchase();

    /**
     * @param string $verifiedPurchase
     * @return self
     */
    public function setVerifiedPurchase($verifiedPurchase);

    /**
     * @return int
     */
    public function getHelpful();

    /**
     * @param int $helpful
     * @return self
     */
    public function setHelpful($helpful);

    /**
     * @return string
     */
    public function getOrigin();

    /**
     * @param string $origin
     * @return self
     */
    public function setOrigin($origin);

    /**
     * @return int
     */
    public function getTargetId();

    /**
     * @param int $targetId
     * @return self
     */
    public function setTargetId($targetId);

    /**
     * @return int
     */
    public function getTopIndex();

    /**
     * @param int $topIndex
     * @return self
     */
    public function setTopIndex($topIndex);

    /**
     * @return string
     */
    public function getResponse();

    /**
     * @param string $response
     * @return self
     */
    public function setResponse($response);

}