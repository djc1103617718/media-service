<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%media}}".
 *
 * @property string $id
 * @property integer $app_id
 * @property integer $category_id
 * @property string $object_id
 * @property string $object_md5_prefix
 * @property string $name
 * @property string $description
 * @property string $content_type
 * @property integer $create_time
 * @property integer $update_time
 */
class Media extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%media}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'app_id', 'category_id', 'object_id', 'object_md5_prefix', 'name', 'description', 'content_type', 'create_time', 'update_time'], 'required'],
            [['id', 'app_id', 'category_id', 'object_id', 'create_time', 'update_time'], 'integer'],
            [['object_md5_prefix'], 'string', 'max' => 8],
            [['name', 'description'], 'string', 'max' => 255],
            [['content_type'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_id' => 'App ID',
            'category_id' => 'Category ID',
            'object_id' => 'Object ID',
            'object_md5_prefix' => 'Object Md5 Prefix',
            'name' => 'Name',
            'description' => 'Description',
            'content_type' => 'Content Type',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return MediaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MediaQuery(get_called_class());
    }
}
