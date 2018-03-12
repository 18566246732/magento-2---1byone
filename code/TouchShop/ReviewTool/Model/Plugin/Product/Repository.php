<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 1/29/18
 * Time: 7:33 PM
 */

namespace TouchShop\ReviewTool\Model\Plugin\Product;

use Magento\Framework\EntityManager\EntityManager;
use Magento\Review\Model\ResourceModel\Review\Collection;
use Magento\Review\Model\Review;
use TouchShop\ReviewTool\Api\Data\ReviewAdvancedExtensionFactory;
use TouchShop\ReviewTool\Api\ReviewAdvancedProviderInterface;

class Repository
{
    /** @var ReviewAdvancedExtensionFactory */
    private $reviewAdvancedExtensionFactory;

    /** @var Review */
    private $review;

    /** @var EntityManager */
    private $entityManager;

    /** @var ReviewAdvancedProviderInterface */
    private $provider;

    public function __construct(
        ReviewAdvancedExtensionFactory $reviewExtensionExtensionFactory,
        EntityManager $entityManager,
        ReviewAdvancedProviderInterface $provider
    )
    {
        $this->reviewAdvancedExtensionFactory = $reviewExtensionExtensionFactory;
        $this->entityManager = $entityManager;
        $this->provider = $provider;
    }

    public function afterAddRateVotes(
        Collection $collection,
        Collection $result
    )
    {
        /** @var \Magento\Review\Model\Review $review */
        foreach ($collection as $review) {
            $this->addReviewAdvancedToReview($review);
        }

        return $result;
    }

//
//    /**
//     * @param \Magento\Review\Model\Review $review
//     * @return \Magento\Review\Model\Review
//     * @throws \Exception
//     */
//    public function afterSave(Review $review)
//    {
//        $this->addReviewAdvancedToReview($review);
//        $extensionAttributes = $review->getExtensionAttributes();
//
//        if ($extensionAttributes && $extensionAttributes->getReviewAdvanced()) {
//            /** @var ReviewAdvanced $reviewAdvanced */
//            $reviewAdvanced = $extensionAttributes->getReviewAdvanced();
//            $this->entityManager->save($reviewAdvanced);
//        }
//        return $review;
//    }


    public function addReviewAdvancedToReview(\Magento\Review\Model\Review $review)
    {
        $extensionAttributes = $review->getExtensionAttributes();
        if (empty($extensionAttributes)) {
            $extensionAttributes = $this->reviewAdvancedExtensionFactory->create();
        }
        $reviewAdvanced = $this->provider->getReviewAdvanced($review->getId());
        $extensionAttributes->setReviewAdvanced($reviewAdvanced);
        $review->setExtensionAttributes($extensionAttributes);
        return $this;
    }
}