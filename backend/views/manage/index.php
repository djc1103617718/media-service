<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Inflector;

$this->registerJsFile('@web/js/view.delete.js', [
    'depends' => [\yii\web\JqueryAsset::className()]
]);

?>
<div class="row">
    <div class="col-sm-3 col-md-2">
        <ul class="nav nav-sidebar">
            <li class="active"><a href="<?= Url::to(['index']) ?>">Index <span class="sr-only">(current)</span></a></li>
            <li><a href="<?= Url::to(['app/index']) ?>">App manage</a></li>
            <li><a href="<?= Url::to(['category/index']) ?>">Category manage</a></li>
            <li><a href="<?= Url::to(['category-mcr-alias/index']) ?>">Category alias manage</a></li>
            <li><a href="<?= Url::to(['category-rule/index']) ?>">Category rules manage</a></li>
        </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-0 col-md-10 col-md-offset-0 main">
        <h1 class="page-header">Dashboard</h1>
        <h2 class="sub-header">Index</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Number</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $number=1; ?>
                <?php foreach ($model as $key => $value):?>
                <tr>
                    <td><?= $number ?></td>
                    <td><?= $key ?></td>
                    <td><?= $value ?></td>
                    <td>
                        <?PHP $key=Inflector::camel2id($key); ?>
                        <a class="glyphicon glyphicon-dashboard" title="View" href="<?=Url::to([$key . '/index']) ?>"></a>
                        <a class="glyphicon glyphicon-trash" title="Delete" action="delete" href="<?=Url::to([$key])?>"></a>
                    </td>
                    <?php $number++; ?>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
