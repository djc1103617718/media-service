<?php

namespace download\components\converters\image;

use Yii;
use download\components\errors\Code;
use yii\web\BadRequestHttpException;
use download\components\errors\Message;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * Class Format
 *
 * @package download\components\image\Format
 */
class Format extends \download\components\converters\image\Image
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
        // Format the image
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

        $data = $img->encode($params);
//        Image::configure(['driver' => 'imagick']);
//        /** @var  the image content $data */
//        $data = Image::make($file)->encode($params);
        @file_put_contents(dirname($file) . '/' . $objectId . '_' . md5(json_encode($md5Data)), $data);

        return dirname($file) . '/' . $objectId . '_' . md5(json_encode($md5Data));
    }
}
