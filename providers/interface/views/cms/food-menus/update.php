<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var dashboard\models\FoodMenus $model */

$this->title = 'Update Food Menus: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Food Menuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="food-menus-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
