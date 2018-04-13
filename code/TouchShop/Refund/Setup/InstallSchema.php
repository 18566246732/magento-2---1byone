<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/12/18
 * Time: 6:03 AM
 */

namespace TouchShop\Refund\Setup;


use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    const TABLE_NAME = 'touchshop_refund';
    const REFUND_ID = 'refund_id';

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
                    self::REFUND_ID,
                    Table::TYPE_BIGINT,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Refund Id'
                )->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )->addColumn(
                    'issue',
                    Table::TYPE_BLOB,
                    '5K',
                    ['nullable' => true],
                    'issue content'
                )->addColumn(
                    'category_id',
                    Table:: TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => true, 'default' => 0],
                    'category id'
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
                    'status',
                    Table::TYPE_TEXT,
                    255,
                    ['unsigned' => true, 'nullable' => true, 'default' => 'Pending'],
                    'Status'
                )->addColumn(
                    'order',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Order id'
                )->addColumn(
                    'reason',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'reason'
                )->addColumn(
                    'address',
                    Table::TYPE_TEXT,
                    2048,
                    ['nullable' => true]
                )->addColumn(
                    'state',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true]
                )->addColumn(
                    'postal_code',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true]
                )->addColumn(
                    'country',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true]
                )->addColumn(
                    'phone',
                    Table::TYPE_TEXT,
                    32,
                    ['nullable' => true]
                )->addColumn(
                    'store_id',
                    Table::TYPE_SMALLINT,
                    null,
                    ['unsigned' => true, 'default' => '0'],
                    'Store id'
                )->addColumn(
                    'type',
                    Table::TYPE_TEXT,
                    32,
                    ['nullable' => false]
                )->addForeignKey(
                    $installer->getFkName(self::TABLE_NAME, 'store_id', 'store', 'store_id'),
                    'store_id',
                    $installer->getTable('store'),
                    'store_id',
                    Table::ACTION_SET_NULL
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