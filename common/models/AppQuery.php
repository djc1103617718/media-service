<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[App]].
 *
 * @see App
 */
class AppQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return App[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return App|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}