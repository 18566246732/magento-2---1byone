<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/8/18
 * Time: 11:36 PM
 */

namespace TouchShop\ReviewTool\Model\Plugin\Product;


use Magento\Framework\EntityManager\EntityManager;
use TouchShop\ReviewTool\Model\ReviewAdvanced;

class ReviewPlugin
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @param \Magento\Review\Model\Review $review
     * @return \Magento\Review\Model\Review
     * @throws \Exception
     */
    public function afterSave(\Magento\Review\Model\Review $review)
    {
        $extensionAttributes = $review->getExtensionAttributes();

        if ($extensionAttributes && $extensionAttributes->getReviewAdvanced()) {
            /** @var ReviewAdvanced $reviewAdvanced */
            $reviewAdvanced = $extensionAttributes->getReviewAdvanced();
            $reviewAdvanced->setReviewId($review->getId());
            $this->entityManager->save($reviewAdvanced);
        }
        return $review;
    }
}