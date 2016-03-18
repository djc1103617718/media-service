<?php

namespace upload\models;

use yii;
use common\models\App;
use common\models\Category;
use common\models\Object;
use common\models\ObjectStorageS3;
use upload\components\s3\S3Helper;
use common\models\ObjectMetaImage;

/**
 * Class Media
 * @package upload\models
 */
class Media extends \common\models\Media
{
    /**
     * @var object $objectMetaImage ObjectMetaImage的对象
     */
    public $objectMetaImage;
    /**
     * @var object $objectStorageS3 ObjectStorageS3的对象
     */
    public $objectStorageS3;
    /**
     * @var object $object Object的对象
     */
    public $object;
    /**
     * @var string $type 返回给用户的类型
     */
    public $type;


    /**
     * 创建两个对象
     *
     * Object constructor.
     */
    public function init()
    {
        $objectMetaImage = new ObjectMetaImage();
        $this->objectMetaImage = $objectMetaImage;
        $objectStorageS3 = new ObjectStorageS3();
        $this->objectStorageS3 = $objectStorageS3;
        $object = new Object();
        $this->object = $object;
    }

    /**
     * 给ObjectStorageS3的所有属性赋值
     *
     * @param object $obj 上传到S3上返回的对象
     * @param string $fileName 文件名
     */
    public function setObjectStorageS3($obj, $fileName)
    {
        $awssdk = Yii::$app->awssdk;
        $this->objectStorageS3->id = $this->object->id;
        $this->objectStorageS3->region = $awssdk->sdkOptions['region'];
        $this->objectStorageS3->bucket = $awssdk->sdkOptions['bucket'];
        $this->objectStorageS3->key = 'temp/' . S3Helper::getKey($fileName);
        $this->objectStorageS3->url = $obj['ObjectURL'];
    }

    /**
     * 给Media对象的所有属性赋值
     *
     * @param array $params 用户通过get传过来的数组
     * @param string $fileName 文件名
     */
    public function setMedia($app, $category)
    {
        $md5 = $this->object->md5;
        $params = Yii::$app->request->get();
        $this->name = $params['name'];
        $this->content_type = $params['content_type'];
        $this->description = $params['description'];
        $this->id = Yii::$app->ticketIdGenerator->generate('media');
        $this->app_id = $app->id;
        $this->category_id = $category->id;
        $objectModel = Object::findOne(['md5' => $md5]);
        if ($objectModel) {
            $this->object_id = $objectModel->id;
        } else {
            $this->object_id = $this->object->id;
        }
        $this->object_md5_prefix = substr($md5, 0, 8);
        $time = time();
        $this->create_time = $time;
        $this->update_time = $time;
    }

    /**
     * @param $obj
     * @param $fileName
     * @throws \Exception
     */
    public function updateS3($obj, $fileName)
    {
        $md5 = md5_file($fileName);
        $object = $this->object->findOne(['md5' => $md5]);
        $objectId = $object->id;
        $objectStorageS3 = $this->objectStorageS3->findOne(['id' => $objectId]);
        $key = 'main/' . S3Helper::getKey($fileName);
        $objectStorageS3->key = $key;
        $objectStorageS3->url = $obj['ObjectURL'];
        $objectStorageS3->update();
    }
}
