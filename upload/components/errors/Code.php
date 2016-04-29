<?php

namespace upload\components\errors;

use yii\base\Object;

/**
 * Class Code
 *
 * @package restful\affiliate\libraries\errors
 */
class Code extends Object
{
    // validate errors
    const VALIDATE_IP_ERROR = 10100;
    const VALIDATE_SIGNATURE_ERROR = 10101;
    const VALIDATE_SIGNATURE_EXPIRES_ERROR = 10102;
    const VALIDATE_APP_KEY_ERROR = 10103;

    // file category error
    const FILE_CATEGORY_ERROR = 11100;
    const VALIDATE_FILE_RULES_WAS_NOT_FOUND = 11101;
    const CATEGORY_RULE_WAS_NOT_FOUND = 11102;

    // input params error
    const INPUT_CATEGORY_URL_NAME_ERROR = 12100;
    const INPUT_NAME_ERROR = 12101;
    const INPUT_DESCRIPTION_ERROR = 12102;
}
