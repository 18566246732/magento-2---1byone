<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/26/18
 * Time: 9:41 PM
 */

namespace TouchShop\Support\Setup;


use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;

class InstallSchema implements InstallSchemaInterface
{
    const TABLE_NAME = 'touchshop_faq';
    const FAQ_ID = 'faq_id';

    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var SchemaSetupInterface $installer */
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists(self::TABLE_NAME)) {
            $table = $installer->getConnection()->newTable($installer->getTable(self::TABLE_NAME))
                ->addColumn(
                    self::FAQ_ID,
                    Table::TYPE_BIGINT,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'FAQ Id'
                )->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )->addColumn(
                    'content',
                    Table::TYPE_BLOB,
                    '5K',
                    ['nullable' => true],
                    'Question content'
                )->addColumn(
                    'product_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true]
                )->addColumn(
                    'customer_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => true]
                )->addColumn(
                    'email',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true]
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
                )->addForeignKey(
                    $installer->getFkName(
                        'catalog_product_entity',
                        'entity_id',
                        self::TABLE_NAME,
                        'product_id'
                    ),
                    'product_id',
                    $installer->getTable('catalog_product_entity'),
                    'entity_id',
                    Table::ACTION_CASCADE
                )->addForeignKey(
                    $installer->getFkName(
                        'customer_entity',
                        'entity_id',
                        self::TABLE_NAME,
                        'customer_id'
                    ),
                    'customer_id',
                    $installer->getTable('customer_entity'),
                    'entity_id',
                    Table::ACTION_CASCADE
                )->setComment(
                    'FQA'
                );

            $installer->getConnection()->createTable($table);
        }
    }
}