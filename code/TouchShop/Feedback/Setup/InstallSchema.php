<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/26/18
 * Time: 9:41 PM
 */

namespace TouchShop\Feedback\Setup;


use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;

class InstallSchema implements InstallSchemaInterface
{
    const TABLE_NAME = 'touchshop_complaint';
    const COMPLAINT_ID = 'complaint_id';

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
                    self::COMPLAINT_ID,
                    Table::TYPE_BIGINT,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Complaint Id'
                )->addColumn(
                    'email',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Email address'
                )->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Contact name'
                )->addColumn(
                    'order',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Order id'
                )->addColumn(
                    'customer_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => true],
                    'Customer id'
                )->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )->addColumn(
                    'status',
                    Table::TYPE_TEXT,
                    255,
                    ['unsigned' => true, 'nullable' => false, 'default' => 'Pending'],
                    'Status'
                )->addColumn(
                    'detail',
                    Table::TYPE_BLOB,
                    '5K',
                    ['nullable' => true],
                    'Issue detail'
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
                    'Complain'
                );

            $installer->getConnection()->createTable($table);
        }
    }
}