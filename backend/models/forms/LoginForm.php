<?php

namespace backend\models\forms;

use backend\models\Admin;
use yii\base\Model;
use yii\base\UserException;

/**
 * Class LoginForm
 * @package backend\models\forms
 */
class LoginForm extends Model
{
    /**
     * @var $login string 登录名
     */
    public $login;
    /**
     * @var $password string 密码
     */
    public $password;
    /**
     * @var $rememberMe string 记录
     */
    public $rememberMe;


    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['login', 'email'],
            [['password'], 'string', 'min' => 6],
            [['rememberMe'], 'integer']
        ];
    }

    /**
     * 验证登录名和密码
     *
     * @return null|static
     */
    public function validateLogin()
    {
        $model = new Admin();
        return $model->findOne(['login' => $this->login, 'password' => $this->password]);
    }

    /**
     * 登陆
     *
     * @return bool
     * @throws UserException
     */
    public function login()
    {
        if ($this->validateLogin() === null) {
            throw new UserException ('用户名和密码错误');
        }
        $identity = Admin::findOne([
            'login' => $this->login,
            'password' => $this->password,
        ]);
        $duration = 0;
        if ($this->rememberMe !== '0') {
            $duration = LOGIN_DURATION;
        }
        return \Yii::$app->user->login($identity, $duration);
    }
}
