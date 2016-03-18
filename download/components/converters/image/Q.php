<?php

namespace download\components\converters\image;

use Yii;
use download\components\errors\Code;
use Intervention\Image\ImageManager;
use yii\web\BadRequestHttpException;
use download\components\errors\Message;

/**
 * Class Quality
 *
 * @package download\components\image\Q
 */
class Q extends Image
{

    /**
     * @param $file
     * @param $params
     * @param $md5Data
     * @return string
     * @throws BadRequestHttpException
     */
    public function view($file, $params, $md5Data)
    {
        // Quality the image
        if (!file_exists($file)) {
            throw new BadRequestHttpException(Message::get(Code::INPUT_FILE_NOT_FOUND));
        }

        // check thumbnail image cache
        if (!strpos(basename ($file), '_')) {
            $objectId = basename ($file);
        } else {
            $objectId = current(explode('_', basename ($file)));
        }

        if (file_exists(dirname($file) . '/' . $objectId . '_' . md5(json_encode($md5Data)))) {
            return dirname($file) . '/' . $objectId . '_' . md5(json_encode($md5Data));
        }

        $manager = new ImageManager(['driver' => 'imagick']);

        $img = $manager->make($file);

        // save file with quality
        $img->save(dirname($file) . '/' . $objectId . '_' . md5(json_encode($md5Data)), (int) $params);

        return dirname($file) . '/' . $objectId . '_' . md5(json_encode($md5Data));
    }
}

