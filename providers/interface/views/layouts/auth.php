<?php

/** @var yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use ui\bundles\DashboardAsset;

DashboardAsset::register($this);

// CSS: Glassmorphism & Animations
$this->registerCss("
    .glass-card {
        background: rgba(255, 255, 255, 0.90) !important; /* Slightly transparent white */
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
    }
    .form-control-alt {
        background-color: #f8f9fa !important; /* Light grey input background */
        border: 1px solid #e9ecef;
    }
    .form-control-alt:focus {
        background-color: #fff !important;
        border-color: #0d6efd; /* Primary color focus */
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }
    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-right: none;
    }
    /* Logo Animation */
    .login-logo { animation: floatDown 0.8s ease-out; }
    @keyframes floatDown { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
");
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - <?= Yii::$app->name ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <div id="page-container">
        <main id="main-container">
            <div class="hero-static d-flex align-items-center justify-content-center bg-image" 
                 style="background-image: url('<?= Yii::getAlias('@web/providers/interface/assets/images/bg.JPG') ?>'); background-size: cover; background-position: center;">
                
                <div class="content content-full">
                    <?= $content ?>
                </div>
                
            </div>
        </main>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>