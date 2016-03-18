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
    public $error_message = '文件类型有误';

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
        $result = in_array($this->media->object->content_type, $this->allowedTypes);
        return $result;
    }
}
