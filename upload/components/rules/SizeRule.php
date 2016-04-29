<?php

namespace upload\components\rules;

/**
 * Class SizeRule
 * @package upload\components\rules
 */
class SizeRule extends Rule
{
    /**
     * @var
     */
    public $min;
    /**
     * @var
     */
    public $max;
    /**
     * @var string
     */
    public $error_message = 'File size dose not fit.';


    /**
     * SizeRule constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * @return bool
     */
    public function check()
    {
        if ($this->context->fileAttr->size <= $this->max && $this->context->fileAttr->size >= $this->min) {
            return true;
        }
        return $this->error_message;
    }
}
