<?php

namespace download\models;

use Yii;
use common\models\Object;
use yii\helpers\Inflector;
use yii\helpers\ArrayHelper;
use Aws\S3\Exception\S3Exception;
use common\models\ObjectStorageS3;
use yii\web\NotFoundHttpException;
use download\components\errors\Code;
use download\components\errors\Message;
use download\components\converters\image\Image;
use download\components\helpers\DownloadHelper;

/**
 * This is the model class for table "media".
 *
 * @property string $id
 * @property integer $app_id
 * @property integer $category_id
 * @property string $object_id
 * @property string $object_md5_prefix
 * @property string $name
 * @property string $description
 * @property string $content_type
 * @property integer $create_time
 * @property integer $update_time
 * @property object object
 * @property Object objectStorageS3
 */
class Media extends \common\models\Media
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'app_id', 'category_id', 'object_id', 'object_md5_prefix', 'name', 'description', 'content_type', 'create_time', 'update_time'], 'required'],
            [['id', 'app_id', 'category_id', 'object_id', 'create_time', 'update_time'], 'integer'],
            [['object_md5_prefix'], 'string', 'max' => 8],
            [['name', 'description'], 'string', 'max' => 255],
            [['content_type'], 'string', 'max' => 128]
        ];
    }

    public function extraFields()
    {
        return ArrayHelper::merge(parent::extraFields(), [
            'object' => 'object',
            'objectStorageS3' => 'objectStorageS3'
        ]);
    }

    public function getObject()
    {
        return $this->hasOne(Object::className(), ['id' => 'object_id']);
    }

    public function getObjectStorageS3()
    {
        return $this->hasOne(ObjectStorageS3::className(), ['id' => 'id'])
            ->via('object');
    }


    /**
     * @param Media $media
     * @param $queryString
     * @return filePath|string
     * @throws NotFoundHttpException
     */
    public function mediaHandle(Media $media, $queryString)
    {
        // Resolve param
        $params = explode('/', $queryString);

        /** @var $action */
        $action = array_shift($params);

        /** @var  $directory  */
        $directory = Yii::getAlias('@download') . '/runtime/object-cache/' . DownloadHelper::cacheDirectory($media->object_id) . '/';
        !file_exists($directory) && (mkdir($directory, 0777, true));

        /**
         * Find the file cache
         * @var  $cacheFileName
         */
        $cacheFileName = $directory . $media->object_id . '_' . md5(json_encode($params));
        if (file_exists($cacheFileName)) {
            return $cacheFileName;
        }

        /** find the file cache of s3 */
        if (!file_exists($directory . $media->object_id)) {
            $s3cacheFile = $this->getS3File(
                $media->objectStorageS3->region,
                $media->objectStorageS3->bucket,
                $media->objectStorageS3->key,
                $directory . $media->object_id
            );
        } else {
            $s3cacheFile = $directory . $media->object_id;
        }

        if (empty($action)) {
            return $s3cacheFile;
        }
        // Find the action
        $action = 'do' . Inflector::id2camel($action);
        if (!method_exists($this, $action)) {
            throw new NotFoundHttpException(Message::get(Code::MEDIA_HANDLE_NOT_MATCH));
        }

        return $this->$action($s3cacheFile, $params);
    }

    public function doImage($file, $params)
    {
        /** @var verify the cache fileName $md5Data */
        $md5Data = [];
        foreach ($params as $k => $v) {
            /** 直接掉类文件函数 */
            $className = '\download\components\converters\image\\' . Inflector::id2camel($v);
            try {
                $imageObj = Yii::createObject($className);
                if (!$imageObj instanceof Image) {
                    continue;
                }
                $md5Data[] = $v;
                $md5Data[] = $params[$k + 1];
                $file = $imageObj->view($file, $params[$k + 1], $md5Data);
            } catch (\Exception $e) {
                continue;
            }
        }
        return $file;
    }

    /**
     * @param $region
     * @param $bucket
     * @param $key
     * @param $filePath
     * @return filePath
     * @throws NotFoundHttpException
     */
    public function getS3File($region, $bucket, $key, $filePath)
    {
        $client = Yii::$app->awssdk->getSdk()->createClient('s3', [
            'region' => $region
        ]);

        if (!$client->doesObjectExist($bucket, $key)) {
            throw new NotFoundHttpException(Message::get(Code::AWS_S3_FILE_NOT_FOUND));
        }

        try {
            $client->getObject([
                'Bucket' => $bucket,
                'Key' => $key,
                'SaveAs' => $filePath
            ]);
        } catch (S3Exception $e) {
            Yii::warning($e->getMessage());
        }

        return $filePath;
    }
}
