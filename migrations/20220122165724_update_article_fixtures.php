<?php

use Phoenix\Migration\AbstractMigration;
//use Phoenix\Migration\AbstractMigration;
use Phoenix\Database\Element\Index;

class UpdateArticleFixtures extends AbstractMigration
{
    protected function up(): void
    {
         $this->table('quote')
            ->addColumn('user_id', 'string')
            ->addColumn('name', 'string')
            ->addColumn('symbol', 'string')
            ->addColumn('open', 'float')
            ->addColumn('high', 'float')
            ->addColumn('low', 'float')
            ->addColumn('close', 'float')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
//            ->addIndex('user', Index::TYPE_UNIQUE)
            ->create();
         
         $this->table('users')
            
            ->addColumn('name', 'string')
            ->addColumn('user', 'string')            
            ->addColumn('pass', 'string')            
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addIndex('user', Index::TYPE_UNIQUE)
            ->create();
         
    }

    protected function down(): void
    {
         $this->table('quote')
            ->drop();
         $this->table('users')
            ->drop();
    }
}
