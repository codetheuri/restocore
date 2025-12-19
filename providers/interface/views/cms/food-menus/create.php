<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var dashboard\models\FoodMenus $model */

$this->title = 'Create Food Menus';
$this->params['breadcrumbs'][] = ['label' => 'Food Menuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-menus-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
