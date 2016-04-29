<?php

namespace backend\models;

use yii;
use yii\base\Model;

/**
 * Class CategoryRule
 * @package backend\models
 */
class CategoryRule extends \common\models\CategoryRule
{
    /**
     * category_id对应的category_name
     *
     * @var array $categoryName
     */
    public $categoryName;


    /**
     * 初始化
     */
    public function init()
    {
        $model = (new Category())->find()->all();
        foreach ($model as $category) {
            $this->categoryName[$category->id] = $category->name;
        }
        $this->on(static::EVENT_BEFORE_VALIDATE, function () {
            if ($this->create_time === null) {
                $this->create_time = time();
            }
            $this->update_time = time();
        });
        $this->on(static::EVENT_BEFORE_UPDATE, function () {
            $this->update_time = time();
        });
        $this->on(static::EVENT_BEFORE_INSERT, function () {
            $this->create_time = time();
            $this->update_time = time();
        });
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category Name',
            'rule_name' => 'Rule Name',
            'rule_params' => 'Rule Params',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
