<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(10)->unsigned(),
            'auth_key' => $this->string()->notNull(),
            'username' => $this->string()->notNull(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'email' => $this->string(),
            'photo_url' => $this->string(),
            'timezone' => $this->smallInteger(2)->unsigned(),
            'locale' => $this->smallInteger(2)->unsigned(),
            'status' => $this->smallInteger(2)->notNull()->defaultValue(0)->unsigned(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ]);

        $this->createTable('auth_source', [
            'id' => $this->smallInteger(2)->notNull()->unsigned(),
            'alias' => $this->string(10)->notNull(),
            'title' => $this->string(20)->notNull(),
        ]);
        $this->addPrimaryKey('auth_source__pk', 'auth_source', ['id']);

        $this->createTable('auth', [
            'id' => $this->string(128)->notNull(),
            'source_id' => $this->smallInteger(2)->notNull()->unsigned(),
            'user_id' => $this->integer(10)->notNull()->unsigned(),
            'token' => $this->text()->notNull(),
            'data' => $this->text()->notNull(),
        ]);
        $this->addPrimaryKey('auth__pk', 'auth', ['id']);

        $this->addForeignKey('fk-auth-user_id-user-id', 'auth', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-auth_source-source_id-source-id', 'auth', 'source_id', 'auth_source', 'id', 'CASCADE', 'CASCADE');

        $this->insert('auth_source', [
            'id' => \common\clients\Facebook::ID,
            'alias' => \common\clients\Facebook::CODE,
            'title' => ucfirst(common\clients\Facebook::CODE)
        ]);

        $this->insert('auth_source', [
            'id' => \common\clients\Twitter::ID,
            'alias' => \common\clients\Twitter::CODE,
            'title' => ucfirst(common\clients\Twitter::CODE)
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('auth');
        $this->dropTable('user');
        $this->dropTable('auth_source');
    }
}