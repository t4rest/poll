<?php

use yii\db\Migration;

class m170709_150442_pool extends Migration
{
    public function safeUp()
    {
        $this->createTable('pool_type', [
            'id' => $this->smallInteger(1)->notNull()->unsigned(),
            'alias' => $this->string(10)->notNull(),
            'title' => $this->string(20)->notNull(),
        ]);
        $this->addPrimaryKey('pool_type__pk', 'pool_type', ['id']);

        $this->createTable('pool', [
            'id' => $this->primaryKey(10)->unsigned(),
            'user_id' => $this->integer(10)->notNull()->unsigned(),
            'type_id' => $this->smallInteger(1)->notNull()->unsigned(),
            'is_hot' => $this->smallInteger(1)->notNull()->defaultValue(0),
//            'photo_url' => tigrov\pgsql\Schema::A,

            'data' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ]);
        $this->execute('ALTER TABLE pool ADD COLUMN photos_url "varchar"(255)[]');

        $this->addForeignKey('fk-pool-user_id-user-id', 'pool', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-pool_type-type_id-type-id', 'pool', 'type_id', 'pool_type', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('pool_choice', [
            'id' => $this->primaryKey(10)->unsigned(),
            'pool_id' => $this->integer(10)->notNull()->unsigned(),
            'data' => $this->string()->notNull(),
            'count' => $this->integer(10)->notNull()->unsigned()->defaultValue(0),
        ]);
        $this->addForeignKey('fk-choice-pool_id-pool-id', 'pool_choice', 'pool_id', 'pool', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('pool_user_choice', [
            'pool_id' => $this->integer(10)->notNull()->unsigned(),
            'user_id' => $this->integer(10)->notNull()->unsigned(),
            'choice_id' => $this->integer(10)->notNull()->unsigned(),
            'date' => $this->timestamp()->notNull(),
        ]);
        $this->addPrimaryKey('user_choice__pk', 'pool_user_choice', ['pool_id', 'user_id', 'choice_id']);

        $this->addForeignKey('fk-user_choice-pool_id-pool-id', 'pool_user_choice', 'pool_id', 'pool', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-user_choice-user_id-user-id', 'pool_user_choice', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-user_choice-choice_id-choice-id', 'pool_user_choice', 'choice_id', 'pool_choice', 'id', 'CASCADE', 'CASCADE');


        $this->insert('pool_type', ['id' => 1, 'alias' => 'text', 'title' => 'Text']);
        $this->insert('pool_type', ['id' => 2, 'alias' => 'single', 'title' => 'Single Photo']);
        $this->insert('pool_type', ['id' => 3, 'alias' => 'compare', 'title' => 'Photo comparison']);
    }

    public function safeDown()
    {
        $this->dropTable('pool_user_choice');
        $this->dropTable('pool_choice');
        $this->dropTable('pool');
        $this->dropTable('pool_type');
    }
}
