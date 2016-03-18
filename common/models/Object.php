<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%object}}".
 *
 * @property string $id
 * @property string $md5
 * @property string $sha1
 * @property integer $type
 * @property string $content_type
 * @property integer $size
 * @property integer $storage_type
 * @property integer $create_time
 * @property integer $update_time
 */
class Object extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%object}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'md5', 'sha1', 'type', 'content_type', 'size', 'create_time', 'update_time'], 'required'],
            [['id', 'type', 'size', 'storage_type', 'create_time', 'update_time'], 'integer'],
            [['md5'], 'string', 'max' => 32],
            [['sha1'], 'string', 'max' => 40],
            [['content_type'], 'string', 'max' => 128],
            [['md5', 'sha1'], 'unique', 'targetAttribute' => ['md5', 'sha1'], 'message' => 'The combination of Md5 and Sha1 has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'md5' => 'Md5',
            'sha1' => 'Sha1',
            'type' => 'Type',
            'content_type' => 'Content Type',
            'size' => 'Size',
            'storage_type' => 'Storage Type',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return ObjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ObjectQuery(get_called_class());
    }
}
