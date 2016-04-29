<?php

use yii\db\Migration;

class m160406_062407_create_table_admin_log extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_log', [
            'id'  => "int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID'",
            'admin_id' => "int(10) unsigned NOT NULL COMMENT '管理员ID'",
            'type' => "varchar(64) NOT NULL COMMENT '业务类型'",
            'message' => "varchar(128) NOT NULL COMMENT '信息'",
            'ip' => "varchar(128) NOT NULL COMMENT '登陆IP'",
            'create_time' => "int(10) unsigned NOT NULL COMMENT '创建时间'",
            "PRIMARY KEY (`id`)"
        ], "ENGINE=`InnoDB` DEFAULT CHARSET=`utf8`");
    }

    public function safeDown()
    {
        $this->dropTable('admin_log');
    }
}
