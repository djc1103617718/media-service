<?php

namespace upload\controllers;

use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\UserException;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use common\models\Category;
use common\dict\Dict;
use common\models\CategoryRule;
use upload\components\rules\Rule;
use upload\components\helpers\S3;
use upload\components\base\Controller;
use upload\models\Media;
use upload\models\Object;
use upload\components\exception\BussinessLogicException;
use upload\components\helpers\File;
use upload\models\ObjectMetaImage;
use upload\models\ObjectStorageS3;
use upload\components\errors\Code;
use upload\components\file\FileAttr;
use upload\components\rules\Context;

/**
 * Class CategoriesController
 *
 * @package upload\controllers
 *
 */
class MediaController extends Controller
{
    /**
     * @return array
     * @throws UserException
     * @throws \Exception
     */
    public function actionCreate()
    {
        $media = new Media();
        $filename = $this->saveInputFile();
        $fileAttr = File::getFileAtrr($filename);
        $fileAttrModel = new FileAttr();
        $fileAttrModel->setAttributes($fileAttr, false); ;
        $context = new Context();
        $context->fileAttr = $fileAttrModel;
        $allAttr = ArrayHelper::merge(
            (array)$fileAttr,
            Yii::$app->request->get()
        );
        $object = Object::findOne([
            'md5' => $allAttr['md5'],
            'sha1' => $allAttr['sha1'],
        ]);

        // 判断传入的category_url_name是否在Category表中有对应的类
        $category_url_name = Yii::$app->request->get('category_url_name');
        $category = Category::findOne(['url_name' => $category_url_name]);
        if ($category === null) {
            throw new BussinessLogicException(Code::INPUT_CATEGORY_URL_NAME_ERROR);
        }
        $this->categoryRule($category, $context);
        if ($object) {
            $media = $this->setMedia($media, $category, $object, $allAttr);
            $media->save();
            @unlink($filename);
            return $media->fields();
        }

        // 给$object的所有属性赋值
        $object = $this->setObject($allAttr);
        // 给$media的所有属性赋值
        $media = $this->setMedia($media, $category, $object, $allAttr);
        // 给$objectMetaImage的所有属性赋值
        $objectMetaImage = $this->setObjectMetaImage($allAttr, $object->id);

        // 将文件传送到S3的临时文件中
        $s3Object = S3::putS3($filename, 'temp');

        // 给$objectStorageS3的所有属性赋值
        $objectStorageS3  = $this->setObjectStorageS3($s3Object, $object->id, $filename);

        Yii::$app->db->transaction(function () use ($object, $objectMetaImage, $objectStorageS3, $media) {
            $object->save(false);
            $objectMetaImage->save(false);
            $objectStorageS3->save(false);
            $media->save();
        });
        try {
            $result = S3::copyS3($filename, 'main', 'temp');
            S3::deleteS3($filename, 'temp');
            $objectStorageS3->updateS3($result, $filename);

        } catch (Exception $e) {
        }
        @unlink($filename);
        return $media->fields();
    }

    /**
     * @return resource
     */
    public function saveInputFile()
    {
        $fp = fopen("php://input", "rb");
        $filename = sprintf('%s/runtime/temp/%s', Yii::getAlias('@upload'), uniqid());
        return File::writeFile($fp, $filename);
    }

    /**
     * @param $media
     * @param $category
     * @param $object
     * @param $allAttr
     * @return mixed
     */
    public function setMedia($media, $category, $object, $allAttr)
    {
        $media->id = Yii::$app->ticketIdGenerator->generate('media');
        $media->app_id = $this->app->id;
        $media->category_id = $category->id;
        $media->object_md5_prefix = substr($allAttr['md5'], 0, 8);
        $media->name = Yii::$app->request->get('name');
        $media->description = Yii::$app->request->get('description');
        if(Yii::$app->request->get('content_type') !== null) {
            $media->content_type = Yii::$app->request->get('content_type');
        } else {
            $media->content_type = $object->content_type;
        }
        $media->object_id = $object->id;
        return $media;
    }

    /**
     * @param $allAttr
     * @return Object
     */
    public function setObject($allAttr)
    {
        $object = new Object();
        $object->attributes = $allAttr;
        $object->id = Yii::$app->ticketIdGenerator->generate('object');
        $object->storage_type = Dict::OBJECT_STORAGE_TYPE_S3;
        return $object;
    }

    /**
     * @param $allAttr
     * @param $objectId
     * @return ObjectMetaImage
     */
    public function setObjectMetaImage($allAttr, $objectId)
    {
        $objectMetaImage = new ObjectMetaImage();
        $objectMetaImage->attributes = $allAttr['meta'];
        $objectMetaImage->id = $objectId;
        return $objectMetaImage;
    }

    /**
     * @param $s3Object
     * @param $objectId
     * @param $filename
     * @return ObjectStorageS3
     */
    public function setObjectStorageS3($s3Object, $objectId, $filename)
    {
        $objectStorageS3 = new ObjectStorageS3();
        $awssdk = Yii::$app->awssdk;
        $objectStorageS3->id = $objectId;
        $objectStorageS3->region = $awssdk->sdkOptions['region'];
        $objectStorageS3->bucket = $awssdk->sdkOptions['bucket'];
        $objectStorageS3->key = 'temp/' . S3::getKey($filename);
        $objectStorageS3->url = $s3Object['ObjectURL'];
        return $objectStorageS3;
    }

    /**
     * 验证文件规则
     *
     * @param $category
     * @param $obj
     * @return bool
     * @throws InvalidConfigException
     * @throws UserException
     */
    public function categoryRule($category, $obj)
    {
        $rules = CategoryRule::find()->where(['category_id' => $category->id])->all();
        if ($rules === null) {
            throw new BussinessLogicException(Code::CATEGORY_RULE_WAS_NOT_FOUND);
        }
        foreach ($rules as $rule) {
            $ruleName = $rule['rule_name'];
            $ruleParams = json_decode($rule['rule_params']);
            $ruleParams = get_object_vars($ruleParams);
            $ruleParams['context'] = $obj;
            $className = '\upload\components\rules\\' . Inflector::id2camel($ruleName);
            $ruleObj = \Yii::createObject([
                'class' => $className,
            ], [$ruleParams]);
            if (!($ruleObj instanceof Rule)) {
                throw new BussinessLogicException(Code::VALIDATE_FILE_RULES_WAS_NOT_FOUND);
            }
            if ($ruleObj->check() !== true) {
                throw new UserException($ruleObj->check());
            }
        }
        return true;
    }
}
