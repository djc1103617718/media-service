<?php

namespace backend\controllers;

use Yii;
use yii\base\UserException;
use yii\filters\AccessControl;
use common\models\App;
use common\models\Category;
use common\models\CategoryMcrAlias;
use common\models\CategoryRule;
use backend\components\base\Controller;
use backend\models\Manage;
use backend\models\forms\LoginForm;

/**
 * Class ManageController
 * @package backend\controllers
 */
class ManageController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new Manage();
        return $this->render('index', ['model' => $model]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\UserException
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['index']);
        }
        return $this->render('login', ['model' => $model]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }

    /**
     * @return \yii\web\Response
     * @throws UserException
     */
    public function actionApp()
    {
        $model = (new App())->updateAll(['state' => 0]);
        if ($model === null) {
            throw new UserException('删除不成功');
        }
        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     * @throws UserException
     */
    public function actionCategory()
    {
        $model = (new Category())->updateAll(['state' => 0]);;
        if ($model === null) {
            throw new UserException('删除不成功');
        }
        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     * @throws UserException
     */
    public function actionCategoryMcrAlias()
    {
        $model = (new CategoryMcrAlias())->deleteAll();
        if ($model === null) {
            throw new UserException('删除不成功');
        }
        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     * @throws UserException
     */
    public function actionCategoryRule()
    {
        $model = (new CategoryRule())->deleteAll();
        if ($model === null) {
            throw new UserException('删除不成功');
        }
        return $this->redirect(['index']);
    }
}
