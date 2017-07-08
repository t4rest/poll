<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(10)->unsigned(),
            'auth_key' => $this->string()->notNull(),
            'username' => $this->string()->notNull(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'email' => $this->string(),
            'photo_url' => $this->string(),
            'timezone' => $this->smallInteger(),
            'locale' => $this->smallInteger(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('auth', [
            'id' => $this->string()->notNull(),
            'source_id' => $this->smallInteger()->notNull(),
            'user_id' => $this->integer(10)->notNull()->unsigned(),
            'token' => $this->text()->notNull(),
            'data' => $this->text()->notNull(),
        ]);
        $this->addPrimaryKey('auth_pk', 'auth', ['id']);

        $this->addForeignKey('fk-auth-user_id-user-id', 'auth', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('auth');
        $this->dropTable('user');
    }
}