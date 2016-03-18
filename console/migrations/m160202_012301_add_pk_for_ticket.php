<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m160202_012301_add_pk_for_ticket
 *
 * Create primary key for ticket
 */
class m160202_012301_add_pk_for_ticket extends Migration
{
    public function safeUp()
    {
        $this->dropIndex('name', 'ticket');
        $this->addPrimaryKey('name', 'ticket', 'name');
    }

    public function safeDown()
    {
        $this->dropPrimaryKey('name', 'ticket');
        $this->createIndex('name', 'ticket', 'name', true);
    }
}
