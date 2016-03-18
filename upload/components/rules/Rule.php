<?php

namespace upload\components\rules;

/**
 * Class Rule
 * @package upload\components\rules
 */
abstract class Rule extends \common\models\Media
{
    /**
     * @var
     */
    public $media;

    /**
     * @return mixed
     */
    abstract public function check();
}
