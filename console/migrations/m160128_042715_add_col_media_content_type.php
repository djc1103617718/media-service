<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m160128_042715_add_col_media_content_type
 *
 * Add column: media.content_type
 * Rename column: object.mime_type => object.content_type
 */
class m160128_042715_add_col_media_content_type extends Migration
{
    public function safeUp()
    {
        $this->addColumn('media', 'content_type', "varchar(128) NOT NULL COMMENT 'Content Type' AFTER `description`");
        $this->alterColumn('object', 'mime_type', "varchar(128) NOT NULL COMMENT 'Content Type'");
        $this->renameColumn('object', 'mime_type', 'content_type');
    }

    public function safeDown()
    {
        $this->dropColumn('media', 'content_type');
        $this->alterColumn('object', 'content_type', "varchar(64) NOT NULL COMMENT 'MIME TYPE'");
        $this->renameColumn('object', 'content_type', 'mime_type');
    }
}
