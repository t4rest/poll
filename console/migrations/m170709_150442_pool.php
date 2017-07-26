<?php

use yii\db\Migration;

class m170709_150442_pool extends Migration
{
    public function safeUp()
    {
        $this->createTable('poll_type', [
            'id' => $this->smallInteger(1)->notNull()->unsigned(),
            'alias' => $this->string(10)->notNull(),
            'title' => $this->string(20)->notNull(),
        ]);
        $this->addPrimaryKey('poll_type__pk', 'poll_type', ['id']);

        $this->createTable('poll', [
            'id' => $this->primaryKey(10)->unsigned(),
            'user_id' => $this->integer(10)->notNull()->unsigned(),
            'type_id' => $this->smallInteger(1)->notNull()->unsigned(),
            'is_hot' => $this->smallInteger(1)->notNull()->defaultValue(0),
//            'photo_url' => tigrov\pgsql\Schema::A,

            'data' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ]);
        $this->execute('ALTER TABLE poll ADD COLUMN photos_url "jsonb"');

        $this->addForeignKey('fk-poll-user_id-user-id', 'poll', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-poll_type-type_id-type-id', 'poll', 'type_id', 'poll_type', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('poll_choice', [
            'id' => $this->primaryKey(10)->unsigned(),
            'poll_id' => $this->integer(10)->notNull()->unsigned(),
            'data' => $this->string()->notNull(),
            'count' => $this->integer(10)->notNull()->unsigned()->defaultValue(0),
        ]);
        $this->addForeignKey('fk-choice-poll_id-poll-id', 'poll_choice', 'poll_id', 'poll', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('poll_user_choice', [
            'poll_id' => $this->integer(10)->notNull()->unsigned(),
            'user_id' => $this->integer(10)->notNull()->unsigned(),
            'choice_id' => $this->integer(10)->notNull()->unsigned(),
            'date' => $this->timestamp()->notNull(),
        ]);
        $this->addPrimaryKey('user_choice__pk', 'poll_user_choice', ['poll_id', 'user_id', 'choice_id']);

        $this->addForeignKey('fk-user_choice-poll_id-poll-id', 'poll_user_choice', 'poll_id', 'poll', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-user_choice-user_id-user-id', 'poll_user_choice', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-user_choice-choice_id-choice-id', 'poll_user_choice', 'choice_id', 'poll_choice', 'id', 'CASCADE', 'CASCADE');


        $this->insert('poll_type', ['id' => 1, 'alias' => 'text', 'title' => 'Text']);
        $this->insert('poll_type', ['id' => 2, 'alias' => 'single', 'title' => 'Single Photo']);
        $this->insert('poll_type', ['id' => 3, 'alias' => 'compare', 'title' => 'Photo comparison']);
    }

    public function safeDown()
    {
        $this->dropTable('poll_user_choice');
        $this->dropTable('poll_choice');
        $this->dropTable('poll');
        $this->dropTable('poll_type');
    }
}
