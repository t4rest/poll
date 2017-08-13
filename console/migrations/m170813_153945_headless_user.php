<?php

use yii\db\Migration;

class m170813_153945_headless_user extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'is_headless', $this->smallInteger(1)->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('user', 'is_headless');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170813_153945_headless_user cannot be reverted.\n";

        return false;
    }
    */
}
