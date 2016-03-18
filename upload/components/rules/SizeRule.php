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
    public $error_message = '文件大小不合适';


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
        if ($this->media->object->size <= $this->max && $this->media->object->size >= $this->min) {
            return true;
        }
        return false;
    }
}
