<?php

use yii\db\Migration;

class m160406_031354_create_table_admin extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin', [
            'id'  => "int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id'",
            'login' => "varchar(32) NOT NULL COMMENT '登录名'",
            'password' => "varchar(64) NOT NULL COMMENT '密码'",
            'name' => "varchar(128) NOT NULL COMMENT '昵称'",
            'create_time' => "int(10) unsigned NOT NULL COMMENT '创建时间'",
            'update_time' => "int(10) unsigned NOT NULL COMMENT '更新时间'",
            "PRIMARY KEY (`id`)"
            ], "ENGINE=`InnoDB` DEFAULT CHARSET=`utf8`");
    }

    public function safeDown()
    {
        $this->dropTable('admin');
    }
}
