<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%category_rule}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $rule_name
 * @property string $rule_params
 * @property integer $create_time
 * @property integer $update_time
 */
class CategoryRule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category_rule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'rule_name', 'rule_params', 'create_time', 'update_time'], 'required'],
            [['category_id', 'create_time', 'update_time'], 'integer'],
            [['rule_params'], 'string'],
            [['rule_name'], 'string', 'max' => 32],
            [['category_id', 'rule_name'], 'unique', 'targetAttribute' => ['category_id', 'rule_name'], 'message' => 'The combination of Category ID and Rule Name has already been taken.']
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
            'rule_name' => 'Rule Name',
            'rule_params' => 'Rule Params',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return CategoryRuleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryRuleQuery(get_called_class());
    }
}
