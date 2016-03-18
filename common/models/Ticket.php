<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%ticket}}".
 *
 * @property string $name
 * @property string $sequence
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ticket}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sequence'], 'required'],
            [['sequence'], 'integer'],
            [['name'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'sequence' => 'Sequence',
        ];
    }

    /**
     * @inheritdoc
     * @return TicketQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TicketQuery(get_called_class());
    }
}
