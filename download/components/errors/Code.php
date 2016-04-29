<?php

namespace download\components\errors;

use yii\base\Object;

/**
 * Class Code
 *
     * @package download\libraries\errors
 */
class Code extends Object
{
    // Media errors
    const MEDIA_NOT_FOUND = 10100;
    const MEDIA_RESOLVE_ERROR = 10101;
    const MEDIA_HANDLE_NOT_MATCH = 10102;
    const MEDIA_HASHID_DECODE_ERROR = 10103;

    // Aws s3 file errors
    const AWS_S3_FILE_NOT_FOUND = 11100;

    // Thumbnail image errors
    const THUMBNAIL_IMAGE_MODE_NOT_MATCH = 12100;

    // Input File error
    const INPUT_FILE_NOT_FOUND = 13100;

    // Input converter_name error
    const INPUT_CONVERTER_NAME_ERROR = 14100;

    // Category errors
    const CATEGORY_NOT_FOUND = 15100;

    // CategoryMcrAlias errors
    const CATEGORY_MCR_ALIAS_NOT_FOUND = 16100;
    const CATEGORY_MCR_ALIAS_CONVERTER_NAME_ERROR = 16101;
}