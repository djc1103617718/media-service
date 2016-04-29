<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\App */

$this->title = 'update';
$this->params['breadcrumbs'][] = ['label' => 'index', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following id = <?=$model->id ?> fields to update:</p>

    <?php $form =Activeform::begin([
        'id' => 'update',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <?= $form->field($model, 'category_id')->dropDownList($model->categoryName, ['prompt'=>'category']) ?>
    <?= $form->field($model, 'rule_name') ?>
    <?= $form->field($model, 'rule_params') ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('update', ['class' => 'btn btn-primary', 'name' => 'sign-button']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
