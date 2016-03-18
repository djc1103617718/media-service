<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m160217_093131_create_table_storage
 *
 * 设置以下字段为可空: object_meta_image.latitude/object_meta_image.longitude
 * 删除字段: object.storage_url
 * 创建表: object_storage_s3
 */
class m160217_093131_create_table_storage extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('object', 'type', "tinyint(1) unsigned NOT NULL COMMENT '文件类型'");
        $this->dropColumn('object', 'storage_url');

        $this->alterColumn('object_meta_image', 'latitude', "decimal(10,6) COMMENT '纬度'");
        $this->alterColumn('object_meta_image', 'longitude', "decimal(10,6) COMMENT '经度'");

        $this->createTable('object_storage_s3', [
            'id' => "bigint(20) UNSIGNED NOT NULL COMMENT 'Object ID'",
            'region' => "varchar(64) NOT NULL COMMENT 'S3 Region'",
            'bucket' => "varchar(128) NOT NULL COMMENT 'S3 Bucket'",
            'key' => "varchar(255) NOT NULL COMMENT 'S3 Object Key'",
            "PRIMARY KEY (`id`)",
        ], "ENGINE=`InnoDB` COMMENT='S3存储信息表'");
    }

    public function safeDown()
    {
        $this->alterColumn('object', 'type', "tinyint(1) unsigned NOT NULL COMMENT '文件类型:1-图片,2-视频'");
        $this->addColumn('object', 'storage_url', "varchar(255) NOT NULL COMMENT '访问地址' AFTER `storage_type`");

        $this->alterColumn('object_meta_image', 'latitude', "decimal(10,6) NOT NULL COMMENT '纬度'");
        $this->alterColumn('object_meta_image', 'longitude', "decimal(10,6) NOT NULL COMMENT '经度'");

        $this->dropTable('object_storage_s3');
    }
}
