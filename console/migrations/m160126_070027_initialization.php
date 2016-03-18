<?php

use yii\db\Migration;

/**
 * Class m160126_070027_initialization
 *
 * 初始化DB结构
 */
class m160126_070027_initialization extends Migration
{
    public function safeUp()
    {
        $this->createTable('app', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID'",
            'key' => "varchar(64) NOT NULL COMMENT '授权KEY'",
            'secret' => "varchar(128) NOT NULL COMMENT '授权密钥'",
            'allow_ip' => "varchar(128) NOT NULL COMMENT 'IP白名单'",
            'state' => "tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态:0-已删除,1-正常'",
            'create_time' => "int(10) unsigned NOT NULL COMMENT '创建时间'",
            'update_time' => "int(10) unsigned NOT NULL COMMENT '更新时间'",
            "PRIMARY KEY (`id`)",
            "UNIQUE KEY `key` (`key`)",
            "KEY `state` (`state`)",
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='应用表'");

        $this->createTable('category', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID'",
            'name' => "varchar(128) NOT NULL COMMENT '分类名称'",
            'url_name' => "varchar(32) NOT NULL COMMENT 'URL名称'",
            'state' => "tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态:0-已删除,1-正常'",
            'create_time' => "int(10) unsigned NOT NULL COMMENT '创建时间'",
            'update_time' => "int(10) unsigned NOT NULL COMMENT '更新时间'",
            "PRIMARY KEY (`id`)",
            "UNIQUE KEY `url_name` (`url_name`)",
            "KEY `state` (`state`)",
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='媒体分类'");

        $this->createTable('category_rule', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID'",
            'category_id' => "int(10) unsigned NOT NULL COMMENT '分类ID'",
            'rule_name' => "varchar(32) NOT NULL COMMENT '规则名'",
            'rule_params' => "text NOT NULL COMMENT '规则参数'",
            'create_time' => "int(10) unsigned NOT NULL COMMENT '创建时间'",
            'update_time' => "int(10) unsigned NOT NULL COMMENT '更新时间'",
            "PRIMARY KEY (`id`)",
            "UNIQUE KEY `category_id` (`category_id`,`rule_name`) USING BTREE",
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分类规则'");

        $this->createTable('media', [
            'id' => "bigint(20) unsigned NOT NULL COMMENT '自定义分配ID'",
            'app_id' => "int(10) unsigned NOT NULL COMMENT '应用ID'",
            'category_id' => "int(10) unsigned NOT NULL COMMENT '分类ID'",
            'object_id' => "bigint(20) unsigned NOT NULL COMMENT '文件对象ID'",
            'object_cs_prefix' => "varchar(8) NOT NULL COMMENT 'Object checksum 8位前缀,方便基于checksum分片后的object查找'",
            'name' => "varchar(255) NOT NULL COMMENT '原始文件名'",
            'description' => "varchar(255) NOT NULL COMMENT '描述'",
            'create_time' => "int(10) unsigned NOT NULL COMMENT '创建时间'",
            'update_time' => "int(10) unsigned NOT NULL COMMENT '更新时间'",
            "PRIMARY KEY (`id`)",
            "KEY `category_id` (`category_id`)",
            "KEY `object_id` (`object_id`)",
            "KEY `app_id` (`app_id`)",
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='媒体文件表'");

        $this->createTable('object', [
            'id' => "bigint(20) unsigned NOT NULL COMMENT '自定义分配ID'",
            'checksum' => "varchar(128) NOT NULL COMMENT '校验和'",
            'type' => "tinyint(1) unsigned NOT NULL COMMENT '文件类型:1-图片,2-视频'",
            'mime_type' => "varchar(64) NOT NULL COMMENT 'MIME TYPE'",
            'size' => "int(10) unsigned NOT NULL COMMENT '文件大小'",
            'storage_type' => "tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '存储类型:1-Amazon S3'",
            'storage_url' => "varchar(255) NOT NULL COMMENT '访问地址'",
            'create_time' => "int(10) unsigned NOT NULL COMMENT '创建时间'",
            'update_time' => "int(10) unsigned NOT NULL COMMENT '更新时间'",
            "PRIMARY KEY (`id`)",
            "UNIQUE KEY `checksum` (`checksum`) USING HASH",
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文件对象'");

        $this->createTable('object_meta_image', [
            'id' => "bigint(20) unsigned NOT NULL COMMENT 'Object ID'",
            'width' => "int(10) unsigned NOT NULL COMMENT '宽'",
            'height' => "int(10) unsigned NOT NULL COMMENT '高'",
            'latitude' => "decimal(10,6) DEFAULT NULL COMMENT '纬度'",
            'longitude' => "decimal(10,6) DEFAULT NULL COMMENT '经度'",
            "PRIMARY KEY (`id`)",
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文件对象元数据'");

        $this->createTable('ticket', [
            'name' => "varchar(32) NOT NULL COMMENT '名称'",
            'sequence' => "bigint(20) unsigned NOT NULL COMMENT '序号'",
            "UNIQUE KEY `name` (`name`) USING HASH",
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Ticket发号计数器'");
    }

    public function safeDown()
    {
        $this->dropTable('app');
        $this->dropTable('category');
        $this->dropTable('category_rule');
        $this->dropTable('media');
        $this->dropTable('object');
        $this->dropTable('object_meta_image');
        $this->dropTable('ticket');
    }
}
