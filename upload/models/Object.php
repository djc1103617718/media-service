<?php

namespace upload\models;

use yii;

class Object extends \common\models\Object
{
    /**
     *初始化
     */
    public function init()
    {
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
    }
}
