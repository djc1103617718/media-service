<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%category_mcr_alias}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $pattern
 * @property string $converter_name
 * @property string $converter_params
 * @property integer $create_time
 * @property integer $update_time
 */
class CategoryMcrAlias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category_mcr_alias}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'pattern', 'converter_name', 'converter_params', 'create_time', 'update_time'], 'required'],
            [['category_id', 'create_time', 'update_time'], 'integer'],
            [['pattern', 'converter_name'], 'string', 'max' => 32],
            [['converter_params'], 'string', 'max' => 255],
            [['category_id', 'pattern'], 'unique', 'targetAttribute' => ['category_id', 'pattern'], 'message' => 'The combination of Category ID and Pattern has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'pattern' => 'Pattern',
            'converter_name' => 'Converter Name',
            'converter_params' => 'Converter Params',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return CategoryMcrAliasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryMcrAliasQuery(get_called_class());
    }
}
