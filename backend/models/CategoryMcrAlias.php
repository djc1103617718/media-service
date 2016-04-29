<?php

namespace backend\models;

use yii;

/**
 * Class CategoryMcrAlias
 * @package backend\models
 */
class CategoryMcrAlias extends \common\models\CategoryMcrAlias
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
            'pattern' => 'Pattern',
            'converter_name' => 'Converter Name',
            'converter_params' => 'Converter Params',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
