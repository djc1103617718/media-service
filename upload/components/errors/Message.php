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

        /**
         * General errors
         */
        Code::GENERAL_DATA_VALIDATION_ERROR => 'Data validation failed.',

        // Order errors
        Code::ORDER_NOT_FOUND => 'Order was not found.',
        Code::ORDER_STATUS_CAN_NOT_BE_SET => 'Can\'t update your order. Please check the order status.',
        Code::ORDER_STATUS_CAN_NOT_BE_SET_DIRECTLY => 'Invalid order status specified.',
        Code::ORDER_STATUS_CAN_NOT_BE_SET_QUOTE_NOT_FOUND => 'Can\'t update your order. Quote not found.',
        Code::ORDER_STATUS_CAN_NOT_BE_SET_WORK_ORDER_NOT_FOUND => 'Can\'t update your order. Worker order not found.',
        Code::ORDER_HAS_BEEN_PAID => 'Order has been paid.',

        // Quote errors
        Code::QUOTE_NOT_FOUND => 'Quote was not found.',
        Code::QUOTE_CAN_NOT_SEND_INVALID_ORDER_STATUS => 'Can\'t send your price. Please check the order status.',

        // Quote talk errors
        Code::QUOTE_TALK_INVALID_QUOTE => 'Can\'t add talk. Quote was not found.',

        // Payment errors
        Code::PAYMENT_FAILED_CREDIT_CARD_NOT_FOUND => 'Payment failed. Credit card was not found.',
        Code::PAYMENT_FAILED_GATEWAY_ERROR => 'Payment failed. Payment gateway error.',

        // Order comment errors
        Code::ORDER_COMMENT_ADD_ERROR_ORDER_NOT_FOUND => 'Unable to add comment. Order not found.',
        Code::ORDER_COMMENT_ADD_ERROR_ORDER_NOT_COMPLETED => 'Unable to add comment. Order has not been completed.',
        Code::ORDER_COMMENT_ADD_ERROR_ORDER_NOT_PAID => 'Unable to add comment. Order has not been paid.',

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
