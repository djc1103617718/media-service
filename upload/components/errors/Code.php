<?php

namespace upload\errors;

use yii\base\Object;

/**
 * Class Code
 *
 * @package restful\affiliate\libraries\errors
 */
class Code extends Object
{
    // General errors
    const GENERAL_DATA_VALIDATION_ERROR = 10100;

    // Order errors
    const ORDER_NOT_FOUND = 11100;
    const ORDER_STATUS_CAN_NOT_BE_SET = 11101;
    const ORDER_STATUS_CAN_NOT_BE_SET_DIRECTLY = 11102;
    const ORDER_STATUS_CAN_NOT_BE_SET_QUOTE_NOT_FOUND = 11103;
    const ORDER_STATUS_CAN_NOT_BE_SET_WORK_ORDER_NOT_FOUND = 11104;
    const ORDER_HAS_BEEN_PAID = 11105;

    // Quote errors
    const QUOTE_NOT_FOUND = 12100;
    const QUOTE_CAN_NOT_SEND_INVALID_ORDER_STATUS = 12101;

    // Quote talk errors
    const QUOTE_TALK_INVALID_QUOTE = 13100;

    // Payment errors
    const PAYMENT_FAILED_CREDIT_CARD_NOT_FOUND = 14100;
    const PAYMENT_FAILED_GATEWAY_ERROR = 14101;

    // Order comment errors
    const ORDER_COMMENT_ADD_ERROR_ORDER_NOT_FOUND = 15100;
    const ORDER_COMMENT_ADD_ERROR_ORDER_NOT_COMPLETED = 15101;
    const ORDER_COMMENT_ADD_ERROR_ORDER_NOT_PAID = 15102;
}
