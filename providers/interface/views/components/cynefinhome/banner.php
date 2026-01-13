<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $banners dashboard\models\Banners[] */
?>

<div class="carousel">
    <div class="container-fluid">
        <div class="owl-carousel">
            
            <?php if (!empty($banners)): ?>
                <?php foreach ($banners as $banner): ?>
                    <div class="carousel-item">
                        <div class="carousel-img">
                            <?= Html::img('@web/' . $banner->image_link, ['alt' => $banner->title]); ?>
                        </div>
                        <div class="carousel-text">
                            <h1><?= Html::encode($banner->title) ?></h1>
                            <p>
                                <?= Html::encode($banner->content) ?>
                            </p>
                            <div class="carousel-btn">
                                <a class="btn custom-btn" href="<?= Url::to(['/site/menu']) ?>">View Menu</a>
                             
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
            <?php else: ?>
                <div class="carousel-item">
                    <div class="carousel-img">
                        <?= Html::img('@web/providers/interface/assets/assets/img/carousel-1.jpg', ['alt' => 'Default']); ?>
                    </div>
                    <div class="carousel-text">
                        <h1>Welcome to <span>Qaffee Point</span></h1>
                        <p>
                            Experience the best dining in Mombasa. Add your own banners in the admin dashboard!
                        </p>
                        <div class="carousel-btn">
                            <a class="btn custom-btn" href="">View Menu</a>
                            <a class="btn custom-btn" href="">Book Table</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>