<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%app}}".
 *
 * @property integer $id
 * @property string $key
 * @property string $secret
 * @property string $allowed_ips
 * @property integer $state
 * @property integer $create_time
 * @property integer $update_time
 */
class App extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'secret', 'allowed_ips', 'create_time', 'update_time'], 'required'],
            [['state', 'create_time', 'update_time'], 'integer'],
            [['key'], 'string', 'max' => 64],
            [['secret', 'allowed_ips'], 'string', 'max' => 128],
            [['key'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'secret' => 'Secret',
            'allowed_ips' => 'Allowed IPs',
            'state' => 'State',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return AppQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppQuery(get_called_class());
    }
}
