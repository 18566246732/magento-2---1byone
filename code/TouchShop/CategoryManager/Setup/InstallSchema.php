<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/22/18
 * Time: 6:31 PM
 */

namespace TouchShop\CategoryManager\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;

class InstallSchema implements InstallSchemaInterface
{
    const TABLE_NAME = 'touchshop_category_manager';
    const MANAGER_ID = 'manager_id';

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
                    self::MANAGER_ID,
                    Table::TYPE_BIGINT,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Complaint Id'
                )->addColumn(
                    'email',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Email address'
                )->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Contact name'
                )->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    255,
                    ['unsigned' => true, 'nullable' => true],
                    'Status'
                )->addColumn(
                    'category_id',
                    Table:: TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => true, 'default' => 0],
                    'category id'
                )->addColumn(
                    'store_id',
                    Table::TYPE_SMALLINT,
                    null,
                    ['unsigned' => true, 'default' => '0'],
                    'Store id'
                )->addColumn(
                    'store_name',
                    Table::TYPE_TEXT,
                    512,
                    ['nullable' => true],
                    'Store id'
                )->addForeignKey(
                    $installer->getFkName(self::TABLE_NAME, 'store_id', 'store', 'store_id'),
                    'store_id',
                    $installer->getTable('store'),
                    'store_id',
                    Table::ACTION_SET_NULL
                )->setComment(
                    'Category_Manager'
                );

            $installer->getConnection()->createTable($table);
        }
    }
}