<?php

namespace download\components\converters\image;

use yii\base\Object;

/**
 * Class Image
 *
 * @package download\components\image
 */
abstract class Image extends Object
{
    /**
     * Image with view
     *
     * @param $file
     * @param $params
     * @param $md5Data
     * @return mixed
     */
    abstract public function view($file, $params, $md5Data);
}