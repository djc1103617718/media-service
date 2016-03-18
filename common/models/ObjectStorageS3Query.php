<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ObjectStorageS3]].
 *
 * @see ObjectStorageS3
 */
class ObjectStorageS3Query extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ObjectStorageS3[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ObjectStorageS3|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}