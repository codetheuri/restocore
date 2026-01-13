<?php
use yii\helpers\Url;
use yii\helpers\Html;
use ui\bundles\MainAsset;

MainAsset::register($this);

// Helper function to check if a route is active
function isActive($actionId) {
    return Yii::$app->controller->action->id === $actionId ? 'active' : '';
}
?>

<div class="navbar navbar-expand-lg bg-light navbar-light sticky-top shadow-sm">
    <div class="container-fluid">
        
        <a href="<?= Url::to(['index']) ?>" class="navbar-brand">
            Cynefin <span>Diner</span>
        </a>
        
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            
            <div class="navbar-nav ml-auto">
                <a href="<?= Url::to(['index']) ?>" class="nav-item nav-link <?= isActive('index') ?>">Home</a>
                <a href="<?= Url::to(['about']) ?>" class="nav-item nav-link <?= isActive('about') ?>">About</a>
                <a href="<?= Url::to(['menu']) ?>" class="nav-item nav-link <?= isActive('menu') ?>">Menu</a>
                <a href="<?= Url::to(['blog']) ?>" class="nav-item nav-link <?= isActive('blog') ?> <?= isActive('blog-details') ?>">Stories</a>
                <a href="<?= Url::to(['contact']) ?>" class="nav-item nav-link <?= isActive('contact') ?>">Contact</a>
            </div>
            
            <div class="navbar-nav ml-auto">
                <a href="<?= Url::to(['booking']) ?>" class="btn custom-btn mt-2 mt-lg-0">
                    Book a Table
                </a>
            </div>

        </div>
    </div>
</div>