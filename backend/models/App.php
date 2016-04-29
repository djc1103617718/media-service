<?php

namespace backend\models;

use yii;

/**
 * Class App
 * @package backend\models
 */
class App extends \common\models\App
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
            if ($this->state === null) {
                $this->state = 1;
            }
            if ($this->secret === null) {
                $this->secret = Yii::$app->db->createCommand('SELECT UUID()')->queryScalar();
            }
            $this->update_time = time();
        });
        $this->on(static::EVENT_BEFORE_UPDATE, function () {
            $this->update_time = time();
        });
        $this->on(static::EVENT_BEFORE_INSERT, function () {
            $this->secret = Yii::$app->db->createCommand('SELECT UUID()')->queryScalar();
            $this->state = 1;
            $this->create_time = time();
            $this->update_time = time();
        });
    }
}
