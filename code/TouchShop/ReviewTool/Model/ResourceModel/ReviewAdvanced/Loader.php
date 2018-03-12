<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 1/29/18
 * Time: 10:51 PM
 */

namespace TouchShop\ReviewTool\Model\ResourceModel\ReviewAdvanced;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\EntityManager\MetadataPool;
use TouchShop\ReviewTool\Api\Data\ReviewAdvancedInterface;

class Loader
{
    /** @var MetadataPool */
    private $metadataPool;

    /** @var ResourceConnection */
    private $resourceConnection;

    public function __construct(
        MetadataPool $metadataPool,
        ResourceConnection $resourceConnection
    )
    {
        $this->metadataPool = $metadataPool;
        $this->resourceConnection = $resourceConnection;
    }

    public function getExtensionIdByReviewId($reviewId)
    {
        $metadata = $this->metadataPool->getMetadata(ReviewAdvancedInterface::class);
        $connection = $this->resourceConnection->getConnection();

        $select = $connection
            ->select()
            ->from($metadata->getEntityTable(), ReviewAdvancedInterface::EXTENSION_ID)
            ->where(ReviewAdvancedInterface::REVIEW_ID . ' = ?', $reviewId);
        $id = $connection->fetchOne($select);
        return $id;

    }


}