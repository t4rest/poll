<?php

use yii\db\Migration;

class m170722_193937_countries extends Migration
{
    public function safeUp()
    {
        $this->createTable("country", [
            "id" => $this->integer(3)->notNull()->unsigned(),
            "iso" => $this->char(2),
            "name" => $this->string(100),
            "nicename" => $this->string(100),
            "iso3" => $this->char(3),
            "numcode" => $this->integer(6),
            "phonecode" => $this->integer(5),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable("country");
    }
}
