<?php

use yii\db\Schema;
use yii\db\Migration;

class m151027_040052_create_feedback_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%feedback}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'age' => Schema::TYPE_INTEGER . ' NOT NULL',
            'sex' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'country' => Schema::TYPE_STRING . ' NOT NULL',
            'state' => Schema::TYPE_STRING . ' NOT NULL',
            'addr1' => Schema::TYPE_STRING . ' NOT NULL',
            'addr2' => Schema::TYPE_STRING . ' NOT NULL',
            'comment' => Schema::TYPE_STRING . ' NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%feedback}}');
    }
}