<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 1/29/18
 * Time: 11:08 PM
 */

namespace TouchShop\ReviewTool\Model;

use TouchShop\ReviewTool\Api\Data\ReviewAdvancedInterface;
use TouchShop\ReviewTool\Api\Data\ReviewAdvancedExtensionInterface;

class ReviewAdvanced implements ReviewAdvancedInterface
{
    /** @var int */
    private $extensionId;

    /** @var int */
    private $reviewId;

    /**@var string */
    private $verifiedPurchase;

    /**@var int */
    private $helpful;

    /**@var string */
    private $origin;

    /**@var int */
    private $targetId;

    /**@var int */
    private $topIndex;

    /**@var string */
    private $response;

    /**
     * @inheritdoc
     */
    public function getExtensionId()
    {
        return $this->extensionId;
    }

    /**
     * @inheritdoc
     */
    public function setExtensionId($extensionId)
    {
        $this->extensionId = $extensionId;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getReviewId()
    {
        return $this->reviewId;
    }

    /**
     * @inheritdoc
     */
    public function setReviewId($reviewId)
    {
        $this->reviewId = $reviewId;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getVerifiedPurchase()
    {
        return $this->verifiedPurchase;
    }

    /**
     * @inheritdoc
     */
    public function setVerifiedPurchase($verifiedPurchase)
    {
        $this->verifiedPurchase = $verifiedPurchase;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getHelpful()
    {
        return $this->helpful;
    }

    /**
     * @inheritdoc
     */
    public function setHelpful($helpful)
    {
        $this->helpful = $helpful;
    }


    /**
     * @inheritdoc
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @inheritdoc
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTargetId()
    {
        return $this->targetId;
    }

    /**
     * @inheritdoc
     */
    public function setTargetId($targetId)
    {
        $this->targetId = $targetId;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTopIndex()
    {
        return $this->topIndex;
    }

    /**
     * @inheritdoc
     */
    public function setTopIndex($topIndex)
    {
        $this->topIndex = $topIndex;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @inheritdoc
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

//    /**
//     * @inheritdoc
//     */
//    public function getExtensionAttributes()
//    {
//        return $this->extensionAttributes;
//    }
//
//    /**
//     * @inheritdoc
//     */
//    public function setExtensionAttributes(
//        \TouchShop\ReviewTool\Api\Data\ReviewAdvancedExtensionInterface $extensionAttributes
//    )
//    {
//        $this->extensionAttributes = $extensionAttributes;
//        return $this;
//    }

}