<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m160127_035327_add_col_object_md5_sha1
 *
 * 将 object.checksum 拆分为 object.md5 & object.sha1
 */
class m160127_035327_add_col_object_md5_sha1 extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('media', 'object_cs_prefix', "varchar(8) NOT NULL COMMENT 'Object md5哈希8位前缀,方便基于md5分片后的object查找'");
        $this->renameColumn('media', 'object_cs_prefix', 'object_md5_prefix');

        $this->addColumn('object', 'md5', "varchar(32) NOT NULL COMMENT 'MD5哈希值' AFTER `checksum`");
        $this->addColumn('object', 'sha1', "varchar(40) NOT NULL COMMENT 'SHA1哈希值' AFTER `md5`");
        $this->dropColumn('object', 'checksum');
        $this->createIndex('md5', 'object', ['md5', 'sha1'], true);
    }

    public function safeDown()
    {
        $this->alterColumn('media', 'object_md5_prefix', "varchar(8) NOT NULL COMMENT 'Object checksum 8位前缀,方便基于checksum分片后的object查找'");
        $this->renameColumn('media', 'object_md5_prefix', 'object_cs_prefix');

        $this->addColumn('object', 'checksum', "varchar(128) NOT NULL COMMENT '校验和' AFTER `id`");
        $this->dropColumn('object', 'md5');
        $this->dropColumn('object', 'sha1');
        $this->createIndex('checksum', 'object', 'checksum', true);
    }
}
