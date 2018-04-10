<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 1/29/18
 * Time: 11:19 PM
 */

namespace TouchShop\ReviewTool\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Db\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{

    const TABLE_NAME = 'touchshop_review_extension';
    const EXTENSION_ID = 'extension_id';

    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable(self::TABLE_NAME)
        )->addColumn(
            self::EXTENSION_ID,
            Table::TYPE_BIGINT,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Extension id'
        )->addColumn(
            'review_id',
            Table::TYPE_BIGINT,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Review id'
        )->addColumn(
            'verified_purchase',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Verified purchase'
        )->addColumn(
            'format',
            Table::TYPE_TEXT,
            2048,
            ['nullable' => true],
            'type format'
        )->addColumn(
            'star',
            Table::TYPE_INTEGER,
            null,
            ['default' => 5]
        )->addColumn(
            'date',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true]
        )->addColumn(
            'author',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true]
        )->addColumn(
            'title',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true]
        )->addColumn(
            'content',
            Table::TYPE_BLOB,
            '5M',
            ['nullable' => true]
        )->addColumn(
            'helpful',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => 0],
            'Votes number'
        )->addColumn(
            'origin',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Origin review_id'
        )->addColumn(
            'top_index',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => true],
            'Top index for order the review'
        )->addColumn(
            'response',
            Table::TYPE_BLOB,
            '5K',
            ['nullable' => true],
            'response of the review'
        )->addColumn(
            'image_urls',
            Table::TYPE_TEXT,
            2048,
            ['nullable' => true]
        )->addColumn(
            'video_urls',
            Table::TYPE_TEXT,
            2048,
            ['nullable' => true]
        )->addColumn(
            'product_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => true]
        )->addColumn(
            'status',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true, 'default' => 'Pending']
        )->addColumn(
            'store_id',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'default' => '0'],
            'Store id'
        )->addForeignKey(
            $installer->getFkName(self::TABLE_NAME, 'store_id', 'store', 'store_id'),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            Table::ACTION_SET_NULL
        )->addIndex(
            $installer->getIdxName(
                $installer->getTable(self::TABLE_NAME),
                ['origin'],
                AdapterInterface::INDEX_TYPE_UNIQUE
            ),
            ['origin'],
            [
                'type' => AdapterInterface::INDEX_TYPE_UNIQUE
            ]
        )->addForeignKey(
            $installer->getFkName(
                self::TABLE_NAME,
                'review_id',
                'review',
                'review_id'
            ),
            'review_id',
            $installer->getTable('review'),
            'review_id',
            Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName(
                self::TABLE_NAME,
                'product_id',
                'catalog_product_entity',
                'entity_id'
            ),
            'product_id',
            $installer->getTable('catalog_product_entity'),
            'entity_id',
            Table::ACTION_CASCADE
        )->setComment(
            'Review extension'
        );

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}