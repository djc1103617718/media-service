<?php

namespace backend\controllers;

use yii;
use yii\data\Pagination;
use yii\helpers\Url;
use backend\components\base\Controller;
use backend\models\CategoryRule;

/**
 * Class CategoryRuleController
 * @package backend\controllers
 */
class CategoryRuleController extends Controller
{
    /**
     * @param null $category_id
     * @return string
     */
    public function actionIndex($category_id = null)
    {
        $categoryRule = new CategoryRule();
        $categoryArr = [];
        foreach ($categoryRule->find()->all() as $value) {
            $categoryArr[$value['category_id']] = $value['categoryName'][$value['category_id']];
        }
        if ($category_id !== null) {
            $totalCount = $categoryRule->find()->where(['category_id' => $category_id])->count();
            $model1 = $categoryRule->find()->where(['category_id' => $category_id]);
        } else {
            $totalCount = $categoryRule->find()->count();
            $model1 = $categoryRule->find();
        }
        $pagination = new Pagination([
            'defaultPageSize' => PAGE_SIZE,
            'totalCount' => $totalCount,
        ]);
        $model = $model1->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('index', [
            'categoryArr' => $categoryArr,
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
        $model = (new CategoryRule())->findOne(['id' => $id]);
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
        $model = new CategoryRule();
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
            (new CategoryRule())->findOne($id)->delete();
            return $this->redirect($returnUrl);
        }
        $selection = (array)Yii::$app->request->post('selection');
        $selection = array_map('intval', $selection);
        $selection = array_unique($selection);
        $selection = array_filter($selection);
        if (!empty($selection)) {
            (new CategoryRule())->deleteAll( ['in', 'id', $selection]);
        }
        return $this->redirect($returnUrl);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = (new CategoryRule())->findOne(['id' => $id]);
        return $this->render('view', ['model' => $model]);
    }
}
