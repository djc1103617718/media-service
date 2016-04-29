<?php

use yii\db\Migration;

class m160325_072446_add_name_to_app extends Migration
{
    public function safeUp()
    {
        $this->addColumn('app', 'name', "varchar(128) NOT NULL COMMENT '名字' AFTER `id`");
        $this->execute('UPDATE `app` SET `name` = `id`');
        $this->createIndex('name', 'app', 'name', true);
    }

    public function safeDown()
    {
        $this->dropColumn('app', 'name');
    }
}
