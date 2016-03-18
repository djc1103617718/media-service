<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m160127_031707_rename_col_app_allow_ip
 *
 * 重命名 app.allow_ip 字段为 app.allowed_ips
 */
class m160127_031707_rename_col_app_allow_ip extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('app', 'allow_ip', 'allowed_ips');
    }

    public function safeDown()
    {
        $this->renameColumn('app', 'allowed_ips', 'allow_ip');
    }
}
