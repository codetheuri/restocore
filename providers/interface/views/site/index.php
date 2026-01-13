<?php
/** @var yii\web\View $this */
$this->title = '| The best restaurant in Mombasa. ';
?> 

<?= $this->render('@ui/views/components/cynefinhome/banner', ['banners' => $banners]) ?>
<?= $this->render('@ui/views/components/cynefinhome/about') ?>
<!-- <?= $this->render('@ui/views/components/cynefinhome/abouthome') ?> -->
<?= $this->render('@ui/views/components/cynefinhome/features') ?>
<?= $this->render('@ui/views/components/cynefinhome/food', ['categories' => $foodCategories]) ?>
<?= $this->render('@ui/views/components/cynefinhome/homeblog', ['blogs' => $latestBlogs]) ?>

