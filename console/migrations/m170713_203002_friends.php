<?php

use yii\db\Migration;

class m170713_203002_friends extends Migration
{
    public function safeUp()
    {
        $this->createTable('user_friend', [
            'user_id' => $this->integer(10)->notNull()->unsigned(),
            'friend_id' => $this->integer(10)->notNull()->unsigned(),
            'date' => $this->timestamp()->notNull(),
        ]);

        $this->addPrimaryKey('user_friend__pk', 'user_friend', ['user_id', 'friend_id']);

        $this->addForeignKey('fk-user_friend-user_id-user-id', 'user_friend', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-user_friend-user_id-friend-id', 'user_friend', 'friend_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('user_friend');
    }
}
