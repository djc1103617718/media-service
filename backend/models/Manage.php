<?php

namespace backend\models;

use yii\base\Model;
use common\models\App;
use common\models\Category;
use common\models\CategoryMcrAlias;
use common\models\CategoryRule;

/**
 * Class Manage
 * @package backend\models
 */
class Manage extends Model
{
    /**
     * @var int|string
     */
    public $app;
    /**
     * @var int|string
     */
    public $category;
    /**
     * @var int|string
     */
    public $categoryMcrAlias;
    /**
     * @var int|string
     */
    public $categoryRule;


    /**
     * Manage constructor.
     */
    public function __construct()
    {
        $this->app = (new App())->find()->where(['state' => 1])->count();
        $this->category = (new Category())->find()->where(['state' => 1])->count();
        $this->categoryMcrAlias = (new CategoryMcrAlias())->find()->count();
        $this->categoryRule = (new CategoryRule())->find()->count();
    }
}
