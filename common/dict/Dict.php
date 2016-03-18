<?php

namespace common\dict;

use yii\base\Object;

/**
 * 业务枚举值
 *
 * @package common\dict
 */
class Dict extends Object
{
    const APP_STATE_DELETED = 0;
    const APP_STATE_ACTIVE = 1;

    public static $appStates = [
        self::APP_STATE_DELETED => 'Deleted',
        self::APP_STATE_ACTIVE => 'Active',
    ];

    const CATEGORY_STATE_DELETED = 0;
    const CATEGORY_STATE_ACTIVE = 1;

    public static $categoryStates = [
        self::CATEGORY_STATE_DELETED => 'Deleted',
        self::CATEGORY_STATE_ACTIVE => 'Active',
    ];

    const OBJECT_TYPE_APPLICATION = 1;
    const OBJECT_TYPE_AUDIO = 2;
    const OBJECT_TYPE_EXAMPLE = 3;
    const OBJECT_TYPE_IMAGE = 4;
    const OBJECT_TYPE_MESSAGE = 5;
    const OBJECT_TYPE_MODEL = 6;
    const OBJECT_TYPE_MULTIPART = 7;
    const OBJECT_TYPE_TEXT = 8;
    const OBJECT_TYPE_VIDEO = 9;

    public static $objectTypes = [
        self::OBJECT_TYPE_APPLICATION => 'application',
        self::OBJECT_TYPE_AUDIO => 'audio',
        self::OBJECT_TYPE_EXAMPLE => 'example',
        self::OBJECT_TYPE_IMAGE => 'image',
        self::OBJECT_TYPE_MESSAGE => 'message',
        self::OBJECT_TYPE_MODEL => 'model',
        self::OBJECT_TYPE_MULTIPART => 'multipart',
        self::OBJECT_TYPE_TEXT => 'text',
        self::OBJECT_TYPE_VIDEO => 'video',
    ];

    const OBJECT_STORAGE_TYPE_S3 = 1;

    public static $objectStorageTypes = [
        self::OBJECT_STORAGE_TYPE_S3 => 'AWS S3',
    ];
}
