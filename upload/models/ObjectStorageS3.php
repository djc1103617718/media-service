<?php

namespace upload\models;

use yii;
use upload\components\helpers\S3;

class ObjectStorageS3 extends \common\models\ObjectStorageS3
{
    /**
     * @return yii\db\ActiveQuery
    /**
     * @param $obj
     * @param $fileName
     * @throws \Exception
     */
    public function updateS3($obj, $fileName)
    {
        $object = new Object();
        $md5 = md5_file($fileName);
        $model = $object->findOne(['md5' => $md5]);
        $objectId = $model->id;
        $objectStorageS3 = self::findOne(['id' => $objectId]);
        $key = 'main/' . S3::getKey($fileName);
        $objectStorageS3->key = $key;
        $objectStorageS3->url = $obj['ObjectURL'];
        $objectStorageS3->update();
    }
}
