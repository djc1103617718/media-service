<?php

namespace backend\models;

use yii;
use yii\web\IdentityInterface;

/**
 * Class Admin
 * @package backend\models
 */
class Admin extends \common\models\Admin implements IdentityInterface
{
    /**
     * @param int|string $id
     * @return null|static
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return null|static
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAuthKey()
    {
        return sha1($this->getId() . Yii::$app->params['user.identity.auth_encrypt_key']);
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
