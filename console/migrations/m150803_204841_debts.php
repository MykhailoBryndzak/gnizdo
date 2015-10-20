<?php

use yii\db\Schema;
use yii\db\Migration;

class m150803_204841_debts extends Migration
{
    public function up()
    {
        $this->createTable('debts_users', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'who_lent' => Schema::TYPE_STRING . ' NOT NULL',
            'debt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'date_debts' => Schema::TYPE_DATETIME . ' NOT NULL'

        ]);

    }

    public function down()
    {
        $this->dropTable('debts_users');
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
