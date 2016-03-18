<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Object]].
 *
 * @see Object
 */
class ObjectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Object[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Object|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}