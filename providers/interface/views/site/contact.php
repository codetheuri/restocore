<?php
/** @var yii\web\View $this */
$this->title = ' Contact Us - Get in Touch with Our Team';
?> 

<?= $this->render('@ui/views/components/cynefincontact/breadcrumbs') ?>
<?= $this->render('@ui/views/components/cynefincontact/contactarea', [
    'model' => $model,
]) ?>
