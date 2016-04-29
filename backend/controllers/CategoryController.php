<?php

namespace backend\controllers;

use yii;
use yii\data\Pagination;
use yii\helpers\Url;
use backend\components\base\Controller;
use backend\models\CategoryMcrAlias;
use backend\models\CategoryRule;
use backend\models\Category;

/**
 * Class CategoryController
 * @package backend\controllers
 */
class CategoryController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $category = new Category();
        $pagination = new Pagination([
            'defaultPageSize' => PAGE_SIZE,
            'totalCount' => $category->find()->where(['state' => 1])->count(),
        ]);
        $model = $category->find()->where(['state' => 1])->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('index', [
            'model' => $model,
            'pagination' => $pagination
        ]);
    }

    /**
     * @param null $id
     * @return string|yii\web\Response
     */
    public function actionUpdate($id = null)
    {
        $model = (new Category())->findOne(['id' => $id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $id]);
        }
        return $this->render('update', ['model' => $model]);
    }

    /**
     * @return string|yii\web\Response
     */
    public function actionCreate()
    {
        $returnUrl = Yii::$app->request->get('url');
        if ($returnUrl === null) {
            $returnUrl = Url::to(['index']);
        }
        $model = new Category();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($returnUrl);
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * @param $id
     * @return yii\web\Response
     */
    public function actionDelete($id = null)
    {
        $returnUrl = Yii::$app->request->post('url');
        if ($returnUrl === null) {
            $returnUrl = Url::previous();
        }
        if ($id !== null) {
            Yii::$app->db->transaction(function () use ($id) {
                $model = (new Category())->findOne($id);
                $model->state = 0;
                $model->update();
                $categoryMcrAlias = new CategoryMcrAlias();
                $categoryMcrAlias->deleteAll(['category_id' => $id]);
                $categoryRule = new CategoryRule();
                $categoryRule->deleteAll(['category_id' => $id]);
            });
            return $this->redirect($returnUrl);
        }
        $selection = (array)Yii::$app->request->post('selection');
        $selection = array_map('intval', $selection);
        $selection = array_unique($selection);
        $selection = array_filter($selection);
        if (!empty($selection)) {
            Yii::$app->db->transaction(function () use ($selection) {
                (new Category())->updateAll(['state' => 0], ['in', 'id', $selection]);
                $categoryMcrAlias = new CategoryMcrAlias();
                $categoryMcrAlias->deleteAll(['in', 'category_id', $selection]);
                $categoryRule = new CategoryRule();
                $categoryRule->deleteAll(['in', 'category_id', $selection]);
            });
        }
        return $this->redirect($returnUrl);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = (new Category())->findOne(['id' => $id]);
        return $this->render('view', ['model' => $model]);
    }
}
