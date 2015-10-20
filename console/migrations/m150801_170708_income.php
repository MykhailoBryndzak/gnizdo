<?php

use yii\db\Schema;
use yii\db\Migration;

class m150801_170708_income extends Migration
{
    public function up()
    {
        $this->createTable('categories_income', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);

        $this->createTable('category_income_users', [
            'id' => Schema::TYPE_PK,
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->createTable('income_users', [
            'id' => Schema::TYPE_PK,
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'income' => Schema::TYPE_INTEGER . ' NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'date' => Schema::TYPE_TIMESTAMP . ' NOT NULL'

        ]);


    }

    public function down()
    {
        $this->dropTable('categories_income');
        $this->dropTable('category_income_users');
        $this->dropTable('income_users');

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
