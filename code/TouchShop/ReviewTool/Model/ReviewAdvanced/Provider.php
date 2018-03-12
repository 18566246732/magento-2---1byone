<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 1/29/18
 * Time: 7:06 PM
 */

namespace TouchShop\ReviewTool\Model\ReviewAdvanced;

use Magento\Framework\EntityManager\EntityManager;
use TouchShop\ReviewTool\Api\Data\ReviewAdvancedInterface;
use TouchShop\ReviewTool\Model\ReviewAdvancedFactory;
use TouchShop\ReviewTool\Model\ResourceModel\ReviewAdvanced\Loader;

class Provider implements \TouchShop\ReviewTool\Api\ReviewAdvancedProviderInterface
{
    /** @var EntityManager */
    private $entityManager;

    /**@var Loader */
    private $loader;

    /** @var ReviewAdvancedFactory */
    private $reviewAdvancedFactory;

    public function __construct(
        EntityManager $entityManager,
        Loader $loader,
        ReviewAdvancedFactory $reviewAdvancedFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->loader = $loader;
        $this->reviewAdvancedFactory = $reviewAdvancedFactory;

    }


    /**
     * @param $reviewId
     * @return ReviewAdvancedInterface
     */
    public function getReviewAdvanced($reviewId)
    {
        $extensionId = $this->loader->getExtensionIdByReviewId($reviewId);

        $reviewAdvanced = $this->reviewAdvancedFactory->create();
        $reviewAdvanced = $this->entityManager->load($reviewAdvanced, $extensionId);

        return $reviewAdvanced;
    }
}