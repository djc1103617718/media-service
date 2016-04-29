<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */

$this->title = 'view';
$this->params['breadcrumbs'][] = ['label' => 'index', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/view.js', [
    'depends' => [\yii\web\JqueryAsset::className()]
]);
?>
<div class="user-detail">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?=Html::a('Update',['update', 'id' => $model->id],['class' => 'btn btn-success']) ?>
        <?=Html::a('Delete',['delete', 'id' => $model->id],['class' => 'btn btn-success', 'action' => 'delete']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url_name',
            'create_time',
            'update_time',
        ]
    ]);?>
</div>
