<?php

namespace backend\models;

use yii;

/**
 * Class Category
 * @package backend\models
 */
class Category extends \common\models\Category
{
    /**
     * 初始化
     */
    public function init()
    {
        $this->on(static::EVENT_BEFORE_VALIDATE, function () {
            if ($this->create_time === null) {
                    $this->create_time = time();
            }
            if ($this->state === null) {
                $this->state = 1;
            }
            $this->update_time = time();
        });
        $this->on(static::EVENT_BEFORE_UPDATE, function () {
            $this->update_time = time();
        });
        $this->on(static::EVENT_BEFORE_INSERT, function () {
            $this->state = 1;
            $this->create_time = time();
            $this->update_time = time();
        });
        parent::init();
    }
}
