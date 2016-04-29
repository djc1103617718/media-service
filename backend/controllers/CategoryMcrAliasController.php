<?php

namespace backend\controllers;

use yii;
use yii\data\Pagination;
use yii\helpers\Url;
use backend\components\base\Controller;
use backend\models\CategoryMcrAlias;

/**
 * Class CategoryMcrAliasController
 * @package backend\controllers
 */
class CategoryMcrAliasController extends Controller
{
    /**
     * @param null $category_id
     * @return string
     */
    public function actionIndex($category_id = null)
    {
        $categoryMcrAlias = new CategoryMcrAlias();
        $categoryArr = [];
        foreach ($categoryMcrAlias->find()->all() as $value) {
            $categoryArr[$value['category_id']] = $value['categoryName'][$value['category_id']];
        }
        if ($category_id !== null) {
            $totalCount = $categoryMcrAlias->find()->where(['category_id' => $category_id])->count();
            $model1 = $categoryMcrAlias->find()->where(['category_id' => $category_id]);
        } else {
            $totalCount = $categoryMcrAlias->find()->count();
            $model1 = $categoryMcrAlias->find();
        }
        $pagination = new Pagination([
            'defaultPageSize' => PAGE_SIZE,
            'totalCount' => $totalCount,
        ]);
        $model = $model1->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('index', [
            'categoryArr' => $categoryArr,
            'model' => $model,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @param $id
     * @return string|yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = (new CategoryMcrAlias())->findOne(['id' => $id]);
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
        $model = new CategoryMcrAlias();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($returnUrl);
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * @param null $id
     * @return yii\web\Response
     * @throws \Exception
     */
    public function actionDelete($id = null)
    {
        $returnUrl = Yii::$app->request->post('url');
        if ($returnUrl === null) {
            $returnUrl = Url::previous();
        }
        if ($id !== null) {
            (new CategoryMcrAlias())->findOne($id)->delete();
            return $this->redirect($returnUrl);
        }
        $selection = (array)Yii::$app->request->post('selection');
        $selection = array_map('intval', $selection);
        $selection = array_unique($selection);
        $selection = array_filter($selection);
        if (!empty($selection)) {
            (new CategoryMcrAlias())->deleteAll( ['in', 'id', $selection]);
        }
        return $this->redirect($returnUrl);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = (new CategoryMcrAlias())->findOne(['id' => $id]);
        return $this->render('view', ['model' => $model]);
    }
}
