<?php

namespace download\controllers;

use Yii;
use yii\web\Controller;
use download\models\Media;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use download\components\errors\Code;
use yii\web\BadRequestHttpException;
use download\components\errors\Message;

class MediaController extends Controller
{
    /**
     * @param $id
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        /** @var decode the id $id */
        $decode = Yii::$app->hashids->decode($id);
        is_array($decode) && $id = current($decode);

        if (empty($id) || !is_numeric($id)) {
            throw new BadRequestHttpException(Message::get(Code::MEDIA_HASHID_DECODE_ERROR));
        }

        // find the media model
        $media = Media::findOne($id);

        if (!$media) {
            throw new NotFoundHttpException(Message::get(Code::MEDIA_NOT_FOUND));
        }

        $file = (new Media())->mediaHandle($media, Yii::$app->request->queryString);

        if (!file_exists($file)) {
            throw new BadRequestHttpException(Message::get(Code::MEDIA_RESOLVE_ERROR));
        }

        $fp = fopen($file, 'rb');

        /** @var  get the content type $finfo */
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file);
        finfo_close($finfo);

        header('Content-Type: ' . $mime);
        header("Content-Length: " . filesize($file));
        header('Cache-Control: max-age=259200');
        header('ETag: ' . md5(ArrayHelper::getValue($media->object, 'md5') . ArrayHelper::getValue($media->object, 'sha1')));
        header('Last-Modified: '. gmdate('M d Y H:i:s', filemtime($file)) . ' GMT');

        fpassthru($fp);exit;
    }
}