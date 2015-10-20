<?php

use yii\db\Schema;
use yii\db\Migration;

class m150920_130611_savings extends Migration
{
    public function up()
    {
        $this->createTable('goals_savings', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->createTable('savings_users', [
            'id' => Schema::TYPE_PK,
            'goal_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'saving' => Schema::TYPE_INTEGER . ' NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'date' => Schema::TYPE_TIMESTAMP . ' NOT NULL'

        ]);
    }

    public function down()
    {
        $this->dropTable('goals_savings');
        $this->dropTable('savings_users');
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
