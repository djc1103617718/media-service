<?php

namespace upload\components\rules;

/**
 * Class ContentTypeRule
 * @package upload\components\rules
 */
class ContentTypeRule extends Rule
{
    /**
     * @var
     */
    public $allowedTypes;
    /**
     * @var string
     */
    public $error_message = 'File category_type is error.';


    /**
     * ContentTypeRule constructor.
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
        if (in_array($this->context->fileAttr->content_type, $this->allowedTypes)) {
            return true;
        }
        return $this->error_message;
    }
}
