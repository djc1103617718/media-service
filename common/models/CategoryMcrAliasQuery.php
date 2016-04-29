<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CategoryMcrAlias]].
 *
 * @see CategoryMcrAlias
 */
class CategoryMcrAliasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return CategoryMcrAlias[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CategoryMcrAlias|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}