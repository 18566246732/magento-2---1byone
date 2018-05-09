<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/20/18
 * Time: 11:44 PM
 */

namespace TouchShop\PowerUser\Setup;


use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    const TABLE_NAME = 'touchshop_power_user';
    const POWER_USER_ID = 'power_user_id';

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
                    self::POWER_USER_ID,
                    Table::TYPE_BIGINT,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'power user Id'
                )->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )->addColumn(
                    'interests',
                    Table::TYPE_TEXT,
                    2048,
                    ['nullable' => true],
                    'Interests'
                )->addColumn(
                    'country',
                    Table::TYPE_TEXT,
                    64,
                    ['nullable' => true],
                    'Country'
                )->addColumn(
                    'customer_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true]
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
                    'Power User'
                );

            $installer->getConnection()->createTable($table);

        }
    }
}