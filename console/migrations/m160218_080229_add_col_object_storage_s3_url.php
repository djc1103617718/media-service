<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m160218_080229_add_col_object_storage_s3_url
 *
 * Add column object_storage_s3.url
 */
class m160218_080229_add_col_object_storage_s3_url extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('object_storage_s3', 'region', "varchar(32) NOT NULL COMMENT 'S3 Region'");
        $this->alterColumn('object_storage_s3', 'bucket', "varchar(32) NOT NULL COMMENT 'S3 Bucket'");
        $this->alterColumn('object_storage_s3', 'key', "varchar(128) NOT NULL COMMENT 'S3 Object Key'");
        $this->addColumn('object_storage_s3', 'url', "varchar(255) NOT NULL COMMENT 'S3 Object URL' AFTER `key`");
    }

    public function safeDown()
    {
        $this->alterColumn('object_storage_s3', 'region', "varchar(64) NOT NULL COMMENT 'S3 Region'");
        $this->alterColumn('object_storage_s3', 'bucket', "varchar(128) NOT NULL COMMENT 'S3 Bucket'");
        $this->alterColumn('object_storage_s3', 'key', "varchar(255) NOT NULL COMMENT 'S3 Object Key'");
        $this->dropColumn('object_storage_s3', 'url');
    }
}
