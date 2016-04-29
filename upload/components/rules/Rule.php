<?php

namespace upload\components\rules;

use yii\base\Object;
/**
 * Class Rule
 * @package upload\components\rules
 */
abstract class Rule extends Object
{
    /**
     * @var Context
     */
    public $context;

    /**
     * @return mixed
     */
    abstract public function check();
}
