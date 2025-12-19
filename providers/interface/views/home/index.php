<?php
use yii\helpers\Url;
use helpers\Html;

$this->title = 'Dashboard';
?>

<div class="bg-image overflow-hidden" 
     style="background-image: url('<?= Yii::getAlias('@web/providers/interface/assets/images/bg.JPG') ?>'); background-position: center; background-size: cover;">
    
    <div style="background-color: rgba(0, 0, 0, 0.3);"> <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center mt-5 mb-2 text-center text-sm-start">
                <div class="flex-grow-1">
                    <h1 class="fw-bold text-white mb-1" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.6);">
                        Welcome, <?= Yii::$app->user->identity->username ?? 'Admin' ?>!
                    </h1>
                    <h2 class="h4 fw-normal text-white-75 mb-0" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">
                        Here is what’s happening at <?= Yii::$app->name ?> today.
                    </h2>
                </div>
                <div class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3">
                    <span class="d-inline-block">
                        <a class="btn btn-primary px-4 py-2" href="<?= Url::to(['/dashboard/food-menu/create']) ?>">
                            <i class="fa fa-plus me-1"></i> New Dish
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="row items-push">
        
        <div class="col-6 col-lg-4">
            <a class="block block-rounded block-link-shadow text-center h-100 mb-0" href="<?= Url::to(['/dashboard/food-menu/index']) ?>">
                <div class="block-content block-content-full">
                    <div class="fs-2 fw-semibold text-primary">
                        <?= $activeMenu ?> <span class="fs-sm fw-medium text-muted">/ <?= $totalMenu ?></span>
                    </div>
                    <div class="fs-sm fw-semibold text-uppercase text-muted">Active Menu Items</div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <i class="fa fa-utensils fa-2x text-primary-lighter"></i>
                </div>
            </a>
        </div>

        <div class="col-6 col-lg-4">
            <a class="block block-rounded block-link-shadow text-center h-100 mb-0" href="<?= Url::to(['/dashboard/blog/index']) ?>">
                <div class="block-content block-content-full">
                    <div class="fs-2 fw-semibold text-smooth"> <?= $publishedBlogs ?>
                    </div>
                    <div class="fs-sm fw-semibold text-uppercase text-muted">Published Posts</div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <i class="far fa-newspaper fa-2x text-smooth-lighter"></i> </div>
            </a>
        </div>

        <div class="col-6 col-lg-4">
            <a class="block block-rounded block-link-shadow text-center h-100 mb-0" href="<?= Url::to(['/dashboard/banner/index']) ?>">
                <div class="block-content block-content-full">
                    <div class="fs-2 fw-semibold text-warning">
                        <?= $activeBanners ?>
                    </div>
                    <div class="fs-sm fw-semibold text-uppercase text-muted">Active Banners</div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <i class="fa fa-images fa-2x text-warning-light"></i>
                </div>
            </a>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="block block-rounded h-100">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Quick Actions</h3>
                </div>
                <div class="block-content">
                    <div class="row g-sm push">
                        <div class="col-6 mb-2">
                            <a class="btn btn-alt-primary w-100 text-start" href="<?= Url::to(['/dashboard/food-menu/create']) ?>"> <i class="fa fa-hamburger me-2"></i> Add Food
                            </a>
                        </div>
                        <div class="col-6 mb-2">
                            <a class="btn btn-alt-info w-100 text-start" href="<?= Url::to(['/dashboard/blog/create']) ?>"> <i class="fa fa-pen-nib me-2"></i> Write Blog
                            </a>
                        </div>
                        <div class="col-6 mb-2">
                            <a class="btn btn-alt-warning w-100 text-start" href="<?= Url::to(['/dashboard/banner/create']) ?>"> <i class="fa fa-image me-2"></i> Add Banner
                            </a>
                        </div>
                        <div class="col-6 mb-2">
                            <a class="btn btn-alt-success w-100 text-start" href="<?= Url::to(['/dashboard/menu-category/create']) ?>"> <i class="fa fa-list me-2"></i> New Category
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="block block-rounded h-100">
                <div class="block-header block-header-default">
                    <h3 class="block-title">System Status</h3>
                </div>
                <div class="block-content">
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Database Status
                            <span class="badge bg-success rounded-pill">Connected</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Upload Directory
                            <span class="badge bg-success rounded-pill">Writable</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            PHP Version
                            <span class="badge bg-secondary rounded-pill"><?= phpversion() ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Framework
                            <span class="badge bg-info rounded-pill">Yii2</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>