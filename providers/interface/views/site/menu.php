<?php
/** @var yii\web\View $this */
/** @var dashboard\models\MenuCategories[] $categories */

$this->title = 'Explore Our Delicious Offerings';
?> 

<?= $this->render('@ui/views/components/cynefinmenu/breadcrumbs') ?>

<?= $this->render('@ui/views/components/cynefinmenu/menu', ['categories' => $categories]) ?>