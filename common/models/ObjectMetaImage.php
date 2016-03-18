<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%object_meta_image}}".
 *
 * @property string $id
 * @property integer $width
 * @property integer $height
 * @property string $latitude
 * @property string $longitude
 */
class ObjectMetaImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%object_meta_image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'width', 'height'], 'required'],
            [['id', 'width', 'height'], 'integer'],
            [['latitude', 'longitude'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'width' => 'Width',
            'height' => 'Height',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    /**
     * @inheritdoc
     * @return ObjectMetaImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ObjectMetaImageQuery(get_called_class());
    }
}
