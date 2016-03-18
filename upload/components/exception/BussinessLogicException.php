<?php

namespace upload\components\exception;

use yii\base\UserException;
use upload\components\errors\Message;

/**
 * Class BussinessLogicException
 *
 * @package restful\affiliate\libraries\exceptions
 */
class BussinessLogicException extends UserException
{
    /**
     * Constructor
     *
     * @param int $code
     * @param string $message
     * @param \Exception $previous
     */
    public function __construct($code, $message = null, \Exception $previous = null)
    {
        if (is_null($message)) {
            $message = Message::get($code);
        }
        parent::__construct($message, $code, $previous);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'BussinessLogicException';
    }
}
