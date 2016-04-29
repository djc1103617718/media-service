<?php

namespace backend\controllers;

use yii;
use yii\helpers\Url;
use yii\data\Pagination;
use backend\components\base\Controller;
use backend\models\App;

/**
 * Class AppController
 * @package backend\controllers
 */
class AppController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $app = new App();
        $pagination = new Pagination([
            'defaultPageSize' => PAGE_SIZE,
            'totalCount' => $app->find()->where(['state' => 1])->count(),
        ]);

        $model = $app->find()->where(['state' => 1])->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('index', [
            'model' => $model,
            'pagination' => $pagination
        ]);
    }

    /**
     * @param $id
     * @return string|yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = (new App())->findOne(['id' => $id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $id]);
        }
        return $this->render('update', ['model' => $model]);
    }

    /**
     * @return string
     */
    public function actionCreate()
    {
        $returnUrl = Yii::$app->request->get('url');
        if ($returnUrl === null) {
            $returnUrl = Url::to(['index']);
        }
        $model = new App();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($returnUrl);
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function actionDelete($id = null)
    {
        $returnUrl = Yii::$app->request->post('url');
        if ($returnUrl === null) {
            $returnUrl = Url::previous();
        }
        if ($id !== null) {
            $model = (new App())->findOne($id);
            $model->state = 0;
            $model->update();
            if ($model->update() !== false) {
                return $this->redirect($returnUrl);
            } else {
                throw new yii\base\UserException('Update failed.');
            }
        }
        $selection = (array)Yii::$app->request->post('selection');
        $selection = array_map('intval', $selection);
        $selection = array_unique($selection);
        $selection = array_filter($selection);
        if (!empty($selection)) {
            (new App())->updateAll(['state' => 0],['in', 'id', $selection]);
        }
        return $this->redirect($returnUrl);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = (new App())->findOne(['id' => $id]);
        return $this->render('view', ['model' => $model]);
    }
}
