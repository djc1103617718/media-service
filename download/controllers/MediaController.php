<?php

namespace download\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use common\models\Category;
use common\models\CategoryMcrAlias;
use download\components\errors\Code;
use download\models\Media;
use download\components\errors\Message;

class MediaController extends Controller
{
    /**
     * @param $category_url_name
     * @param $id
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionView($category_url_name, $id)
    {
        /** @var decode the id $id */
        $decode = Yii::$app->hashids->decode($id);
        is_array($decode) && $id = current($decode);

        if (empty($id) || !is_numeric($id)) {
            throw new BadRequestHttpException(Message::get(Code::MEDIA_HASHID_DECODE_ERROR));
        }

        // find the media model
        $category = Category::findOne(['url_name' => $category_url_name]);
        if(!$category) {
            throw new NotFoundHttpException(Message::get(Code::CATEGORY_NOT_FOUND));
        }
        $categoryId = $category->id;
        $media = Media::findOne(['id' => $id, 'category_id' => $categoryId]);

        if (!$media) {
            throw new NotFoundHttpException(Message::get(Code::MEDIA_NOT_FOUND));
        }

        $query = $this->getParams();
        $file = (new Media())->mediaHandle($media, $query);

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

    /**
     * @return string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function getParams()
    {
        $get = Yii::$app->request->get();
        if (isset($get['c'])) {
            return $get['c'] . '/' . @$get['p'];
        }

        $pattern = array_search('', $get);
        if ($pattern !== false) {
            /** @var object $model CategoryMcrAlias的对象 **/
            $model = CategoryMcrAlias::findone(['pattern' => $pattern]);
            if($model === null) {
             throw new NotFoundHttpException(Message::get(Code::CATEGORY_MCR_ALIAS_NOT_FOUND));
             }
            return $model->converter_name . '/' . $model->converter_params;
        }

        return '';
    }
}