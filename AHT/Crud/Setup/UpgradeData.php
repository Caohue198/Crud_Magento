<?php

namespace AHT\Crud\Setup;

use \Magento\Framework\Setup\UpgradeDataInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Class UpgradeData
 *
 * @package Modulevip\Blog\Setup
 */
class UpgradeData implements UpgradeDataInterface
{

    /**
     * Creates sample blog posts
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if ($context->getVersion()
            && version_compare($context->getVersion(), '1.0.1') < 0
        ) {
            $tableName = $setup->getTable('aht_crud_post');

            $data = [
                [
                    'name'         => "How to Create SQL Setup Script in Magento 2",
                    'post_content' => "In this article, we will find out how to install and upgrade sql script for module in Magento 2. When you install or upgrade a module, you may need to change the database structure or add some new data for current table. To do this, Magento 2 provide you some classes which you can do all of them.",
                    'url_key'      => '/magento-2-module-development/magento-2-how-to-create-sql-setup-script.html',
                    'tags'         => 'magento 2,mageplaza helloworld',
                    'status'       => 1
                ],
                [
                    'name'         => "How to Create ",
                    'post_content' => "In this article, we will find out how to install and upgrade sql script for module in Magento 2. When you install or upgrade a module, you may need to change the database structure or add some new data for current table. To do this, Magento 2 provide you some classes which you can do all of them.",
                    'url_key'      => '/magento-2-module-development/magento-2-how-to-create-sql-setup-script.html',
                    'tags'         => 'magento 2,mageplaza helloworld',
                    'status'       => 1
                ],
            ];

            $setup
                ->getConnection()
                ->insertMultiple($tableName, $data);
        }

        $setup->endSetup();
    }
}