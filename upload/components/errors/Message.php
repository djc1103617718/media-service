<?php

namespace upload\components\errors;

use yii\base\Object;

/**
 * Class Message
 *
 * @package restful\affiliate\libraries\errors
 */
class Message extends Object
{
    /**
     * Error messages
     *
     * @var array
     */
    protected static $messages = [
        // validate errors
        Code::VALIDATE_IP_ERROR => 'Validate Ip was error.',
        Code::VALIDATE_SIGNATURE_ERROR => 'Validate signature was error.',
        Code::VALIDATE_SIGNATURE_EXPIRES_ERROR => 'Validate signature was expired.',
        Code::VALIDATE_APP_KEY_ERROR => 'Validate app_key was error.',

        // file category errors
        Code::FILE_CATEGORY_ERROR => 'File category was error.',
        Code::VALIDATE_FILE_RULES_WAS_NOT_FOUND => 'Validate file attribute rules was not found.',
        Code::CATEGORY_RULE_WAS_NOT_FOUND => 'Category rule was not found.',

        // input params errors
        Code::INPUT_CATEGORY_URL_NAME_ERROR => 'Input category_url_name was error.',
        Code::INPUT_NAME_ERROR=> 'Input name was error.',
        Code::INPUT_DESCRIPTION_ERROR => 'Input description was error.',
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
