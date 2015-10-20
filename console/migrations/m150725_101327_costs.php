<?php

use yii\db\Schema;
use yii\db\Migration;

class m150725_101327_costs extends Migration
{
    public function up()
    {
        $this->createTable('categories_costs', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);

        $this->createTable('category_costs_users', [
            'id' => Schema::TYPE_PK,
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->createTable('costs_users', [
            'id' => Schema::TYPE_PK,
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'cost' => Schema::TYPE_INTEGER . ' NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'date' => Schema::TYPE_TIMESTAMP . ' NOT NULL'
            
        ]);


    }

    public function down()
    {
        $this->dropTable('categories_costs');
        $this->dropTable('category_costs_users');
        $this->dropTable('costs_users');

    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
