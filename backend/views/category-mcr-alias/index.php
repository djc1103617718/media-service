<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $models backend\models\App */

$this->title = 'index';
$this->registerJsFile('@web/js/form.delete.js', [
    'depends' => [\yii\web\JqueryAsset::className()]
]);
$this->registerJsFile('@web/js/select.delete.js', [
    'depends' => [\yii\web\JqueryAsset::className()]
]);

$this->title = 'index';

?>
<div class="row">
    <div class="col-sm-3 col-md-2">
        <ul class="nav nav-sidebar">
            <li><a href="<?= Url::to(['mange/index']) ?>">Index</a></li>
            <li><a href="<?= Url::to(['app/index']) ?>">App manage</a></li>
            <li><a href="<?= Url::to(['category/index']) ?>">Category manage</a></li>
            <li class="active"><a href="<?= Url::to(['index']) ?>">Category alias manage<span class="sr-only">(current)</span></a></li>
            <li><a href="<?= Url::to(['category-rule/index']) ?>">Category rules manage</a></li>
        </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-0 col-md-10 col-md-offset-0 main">
        <h1 class="page-header">Dashboard</h1>
        <div class="row">
            <div style="float:left;margin-left:15px;"><h2><?= Html::encode($this->title) ?></h2></div>
            <div style="float:right;margin-top:30px; margin-right:15px;">
                <a class="btn btn-success" data-action="create" href="<?= Url::to(['create']). '?url=' . Html::encode(Yii::$app->request->url)?>">Create</a>
                <a class="btn btn-success" data-action="delete" href="<?= Url::to(['delete'])?>">Delete</a>
            </div>
        </div>
        <form action="<?=Url::to(['delete'])?>" method="post" id="ql" >
            <input type="hidden" name="url" value="<?= Html::encode(Yii::$app->request->url) ?>">
            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
            <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th data-key="1"><input type="checkbox" class="select-on-check-all" name="selection_all" value="1" id="operAll"></th>
                    <th>Id</th>
                    <th><select name='sldd' style='width:90px' onchange='location.href=this.options[this.selectedIndex].value;'>
                            <option selected>Category</option>
                            <?php foreach ($categoryArr as $key => $value): ?>
                            <option value=?category_id=<?= Html::encode($key) ?>><?= Html::encode($value) ?></option>
                            <?php endforeach; ?>
                        </select></th>
                    <th>Pattern</th>
                    <th>Converter Name</th>
                    <th>Converter Params</th>
                    <th>Create Time</th>
                    <th>Update Time</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($model as $categoryMcrAlias):?>
                    <tr data-key="<?= Html::encode($categoryMcrAlias['id']) ?>">
                        <td><input type="checkbox" value="<?= Html::encode($categoryMcrAlias['id']) ?>" name="selection[]"></td>
                        <td><?= Html::encode($categoryMcrAlias['id']) ?></td>
                        <td><?= Html::encode($categoryMcrAlias['categoryName'][$categoryMcrAlias['category_id']]) ?></td>
                        <td><?= Html::encode($categoryMcrAlias['pattern']) ?></td>
                        <td><?= Html::encode($categoryMcrAlias['converter_name']) ?></td>
                        <td><?= Html::encode($categoryMcrAlias['converter_params']) ?></td>
                        <td><?= Yii::$app->formatter->format(Html::encode($categoryMcrAlias['create_time']), ['datetime', 'php: Y-m-d, H:i:s']) ?></td>
                        <td><?= Yii::$app->formatter->format(Html::encode($categoryMcrAlias['update_time']), ['datetime', 'php: Y-m-d, H:i:s']) ?></td>
                        <td>
                            <?=Url::remember();?>
                            <a class="glyphicon glyphicon-dashboard" title="View" href="<?=Url::to(['view']) . '?id=' . Html::encode($categoryMcrAlias['id']) ?>"></a>
                            <a class="glyphicon glyphicon-pencil" title="Update" href="<?=Url::to(['update']) . '?id=' . Html::encode($categoryMcrAlias['id']) ?>"></a>
                            <a class="glyphicon glyphicon-trash" title="Delete" data-actions="delete" href="<?=Url::to(['delete']) . '?id=' . Html::encode($categoryMcrAlias['id']) ?>"></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        <div id="pagination" align="center">
            <?= LinkPager::widget([
                'pagination' => $pagination,
            ]);?>
        </div>
        </form>
    </div>
</div>
