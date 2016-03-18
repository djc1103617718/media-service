<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ObjectMetaImage]].
 *
 * @see ObjectMetaImage
 */
class ObjectMetaImageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ObjectMetaImage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ObjectMetaImage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}