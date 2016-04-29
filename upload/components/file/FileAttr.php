<?php

namespace upload\components\file;

use yii;
use yii\base\model;

class FileAttr extends model
{
    public $size;
    public $type;
    public $md5;
    public $sha1;
    public $content_type;
    public $meta;
}