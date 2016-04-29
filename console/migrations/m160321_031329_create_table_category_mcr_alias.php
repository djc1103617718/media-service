<?php

use yii\db\Migration;

/**
 * Class m160321_031329_create_table_category_mcr_alias
 *
 * 创建表: category_mcr_alias
 */
class m160321_031329_create_table_category_mcr_alias extends Migration
{
    public function safeUp()
    {
        $this->createTable('category_mcr_alias', [
            'id' => "int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID'",
            'category_id' => "int UNSIGNED NOT NULL COMMENT '分类ID'",
            'pattern' => "varchar(32) NOT NULL COMMENT '别名模式'",
            'converter_name' => "varchar(32) NOT NULL COMMENT '转换器名称'",
            'converter_params' => "varchar(255) NOT NULL COMMENT '转换器参数'",
            'create_time' => "int(10) UNSIGNED NOT NULL COMMENT '创建时间'",
            'update_time' => "int(10) UNSIGNED NOT NULL COMMENT '更新时间'",
	        "PRIMARY KEY (`id`)",
            "UNIQUE USING HASH (category_id, pattern)",
        ], "ENGINE=`InnoDB` COMMENT='分类-媒体-转换规则 别名表'");
    }

    public function safeDown()
    {
        $this->dropTable('category_mcr_alias');
    }
}
