<?php

namespace download\components\errors;

use yii\base\Object;

/**
 * Class Message
 *
 * @package download\libraries\errors
 */
class Message extends Object
{
    /**
     * Error messages
     *
     * @var array
     */
    protected static $messages = [
        // Media errors
        Code::MEDIA_NOT_FOUND => 'Media was not found.',
        Code::MEDIA_RESOLVE_ERROR => 'Media resolve failed.',
        Code::MEDIA_HANDLE_NOT_MATCH => 'Media handle was not match.',
        Code::MEDIA_HASHID_DECODE_ERROR => 'Media ID decode error.',

        // Aws s3 file errors
        Code::AWS_S3_FILE_NOT_FOUND => 'Aws S3 file was not found.',

        // Thumbnail image errors
        Code::THUMBNAIL_IMAGE_MODE_NOT_MATCH => 'Thumbnail image mode was not match.',

        // Input File error
        Code::INPUT_FILE_NOT_FOUND => 'Input file was not found.',
    ];

    /**
     * Get message by code
     *
     * @param int $code
     * @return string|null
     */
    public static function get($code)
    {
        return isset(self::$messages[$code]) ? self::$messages[$code] : null;
    }
}