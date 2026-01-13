<?php
/** @var yii\web\View $this */
/** @var dashboard\models\Blogs[] $blogs */

$this->title = 'Our Latest News and Updates';
?> 

<?= $this->render('@ui/views/components/cynefinblogs/breadcrumbs', ['title' => 'Our Blog']) ?>
<?= $this->render('@ui/views/components/cynefinblogs/blogarea', ['blogs' => $blogs]) ?>