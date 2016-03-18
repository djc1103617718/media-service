<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CategoryRule]].
 *
 * @see CategoryRule
 */
class CategoryRuleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return CategoryRule[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CategoryRule|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}