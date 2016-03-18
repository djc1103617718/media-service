<?php

namespace download\components\converters\image;

use Yii;
use yii\web\NotFoundHttpException;
use download\components\errors\Code;
use yii\web\BadRequestHttpException;
use Intervention\Image\ImageManager;
use download\components\errors\Message;

/**
 * Class Thumbnail
 *
 * @package download\components\image\Thumbnail
 */
class Thumbnail extends Image
{
    // Thumbnail mode
    const MODE_FIXED_WIDTH = 1;
    const MODE_FIXED_HEIGHT = 2;
    const MODE_FIXED_WIDTH_HEIGHT = 3;

    const MODE_ARR = [
        self::MODE_FIXED_WIDTH,
        self::MODE_FIXED_HEIGHT,
        self::MODE_FIXED_WIDTH_HEIGHT,
    ];



    /**
     * thumbnail the image
     *
     * @param $file
     * @param $params
     * @param $md5Data
     * @return \Intervention\Image\Image|string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function view($file, $params, $md5Data)
    {
        if (!file_exists($file)) {
            throw new BadRequestHttpException(Message::get(Code::INPUT_FILE_NOT_FOUND));
        }

        // check thumbnail image cache
        if (!strpos(basename($file), '_')) {
            $objectId = basename($file);
        } else {
            $objectId = current(explode('_', basename($file)));
        }

        if (file_exists(dirname($file) . '/' . $objectId . '_' . md5(json_encode($md5Data)))) {
            return dirname($file) . '/' . $objectId . '_' . md5(json_encode($md5Data));
        }

        // resolve the params 1,100x200
        /** @var the params array  $arr */
        $arr = explode(',', $params);
        $mode = current($arr);

        if (!is_numeric($mode) || !in_array($mode, self::MODE_ARR)) {
            throw new NotFoundHttpException(Message::get(Code::THUMBNAIL_IMAGE_MODE_NOT_MATCH));
        }
        // thumbnail the image
        $manager = new ImageManager(['driver' => 'imagick']);

        $img = $manager->make($file);
        $paramArr = explode('x', end($arr));

        if ($mode == self::MODE_FIXED_WIDTH) {
            $width = current($paramArr);
            $img->resize($width, null);
        } elseif ($mode == self::MODE_FIXED_HEIGHT) {
            $height = end($paramArr);
            $img->resize(null, $height);
        } elseif ($mode == self::MODE_FIXED_WIDTH_HEIGHT) {
            $width = current($paramArr);
            $height = end($paramArr);
            $img->resize($width, $height);
        } else {
            throw new NotFoundHttpException(Message::get(Code::THUMBNAIL_IMAGE_MODE_NOT_MATCH));
        }

        $img->save(dirname($file) . '/' . $objectId . '_' . md5(json_encode($md5Data)));

        return dirname($file) . '/' . $objectId . '_' . md5(json_encode($md5Data));
    }
}

