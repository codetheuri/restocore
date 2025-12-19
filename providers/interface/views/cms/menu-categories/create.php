<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var dashboard\models\MenuCategories $model */

$this->title = 'Create Menu Categories';
$this->params['breadcrumbs'][] = ['label' => 'Menu Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-categories-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
