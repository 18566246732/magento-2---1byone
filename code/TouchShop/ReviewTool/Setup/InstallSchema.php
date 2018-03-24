<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 1/29/18
 * Time: 11:19 PM
 */

namespace TouchShop\ReviewTool\Setup;

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
        )->setComment(
            'Review extension'
        );

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}