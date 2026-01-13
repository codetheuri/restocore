<?php

/** @var yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use ui\bundles\MainAsset;

MainAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title === null ? Yii::$app->name : Yii::$app->name . ' - ' . $this->title) ?></title>
    <?php $this->head() ?>
</head>


<body>
    <?php $this->beginBody() ?>
      <?= $this->render('section-cynefin/_header.php') ?>
    <?= $content ?>
    <?= $this->render('section-cynefin/_footer.php') ?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>