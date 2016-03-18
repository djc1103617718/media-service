<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%object_storage_s3}}".
 *
 * @property string $id
 * @property string $region
 * @property string $bucket
 * @property string $key
 * * @property string $url
 */
class ObjectStorageS3 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%object_storage_s3}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'region', 'bucket', 'key', 'url'], 'required'],
            [['id'], 'integer'],
            [['region'], 'string', 'max' => 64],
            [['bucket'], 'string', 'max' => 128],
            [['key'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region' => 'Region',
            'bucket' => 'Bucket',
            'key' => 'Key',
        ];
    }

    /**
     * @inheritdoc
     * @return ObjectStorageS3Query the active query used by this AR class.
     */
    public static function find()
    {
        return new ObjectStorageS3Query(get_called_class());
    }
}
