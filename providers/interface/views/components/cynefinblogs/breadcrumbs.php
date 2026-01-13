<?php

$pageTitle = isset($title) ? $title : 'Blogs';
?> 
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2><?= \yii\helpers\Html::encode($pageTitle) ?></h2>
            </div>
            <div class="col-12">
                <a href="<?= \yii\helpers\Url::to(['site/index']) ?>">Home</a>
                <a href="<?= \yii\helpers\Url::to(['site/blog']) ?>">Blogs</a>
            </div>
        </div>
    </div>
</div>