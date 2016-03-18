<?php

namespace backend\controllers;

use Yii;
use backend\models\UploadForm;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use GuzzleHttp\Client;
use backend\models\Upload;
use yii\helpers\ArrayHelper;

class UploadController extends Controller
{
    const UPLOAD_BASE_URL = 'http://upload.mp-media-service.app/categories/avatars/medias';
    public $enableCsrfValidation = false;

    public function actionUpload()
    {
        $tempUrl = Yii::getAlias('@backend/runtime/upload/');
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
                $fileUrl = $tempUrl . $model->file->baseName . '.' . $model->file->extension;
                if ($model->validate()) {
                    $model->file->saveAs($fileUrl);
                    $params = [
                        'app_key' => 'testKey',
                        'name' => 'test',
                        'category_url_name' => 'avatars',
                        'secret' => 'testKey',
                        'timestamp' => time(),
                        'description' => 'test',
                        'content_type' => 'test',
                    ];
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    Upload::send(self::UPLOAD_BASE_URL, $params, $fileUrl);
                    //return Json::decode();
                }
        }

        return $this->render('upload', ['model' => $model]);
    }


    public function actionTest()
    {

    }
}

