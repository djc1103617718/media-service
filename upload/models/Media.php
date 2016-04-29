<?php

namespace upload\models;

use yii;
use common\dict\Dict;
use common\models\Category;
use common\models\Object;
use common\models\ObjectStorageS3;
use common\models\ObjectMetaImage;

/**
 * Class Media
 * @package upload\models
 */
class Media extends \common\models\Media
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

    /**
     * @return yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(Object::className(), ['id' => 'object_id']);
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getObjectMetaImage()
    {
        return $this->hasOne(ObjectMetaImage::className(), ['id' => 'object_id']);
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getObjectStorageS3()
    {
        return $this->hasOne(ObjectStorageS3::className(), ['id' => 'object_id']);
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return array
     */
    public function fields()
    {
        unset($this->objectMetaImage['id']);
        $id = Yii::$app->hashids->encode($this->id);
        return [
            'id' => $id,
            'name' => $this->name,
            'description' =>$this->description,
            'content_type' => $this->content_type,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'type' => Dict::$objectTypes[$this->object->type],
            'size' => $this->object->size,
            'url'=> Yii::$app->params['downloadBaseUrl'] . '/' . $this->category->url_name . '/' . $id,
            'meta' => $this->objectMetaImage
        ];
    }
}
