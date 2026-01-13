<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;

/** @var dashboard\models\Blogs[] $blogs */
?>
<div class="blog">
    <div class="container">
        <div class="section-header text-center">
            <p>Food Blog</p>
            <h2>Latest From Food Blog</h2>
        </div>
        
        <div class="row">
            <?php if (!empty($blogs)): ?>
                <?php foreach ($blogs as $blog): ?>
                    <div class="col-md-6">
                        <div class="blog-item">
                            <div class="blog-img">
                                <?php 
                                    $imgUrl = !empty($blog->image_link) ? '@web/' . $blog->image_link : '@web/providers/interface/assets/assets/img/blog-1.jpg';
                                    echo Html::img($imgUrl, ['alt' => $blog->title]); 
                                ?>
                            </div>
                            <div class="blog-content">
                                <h2 class="blog-title"><?= Html::encode($blog->title) ?></h2>
                                <div class="blog-meta">
                                    <p><i class="far fa-user"></i> Admin</p>
                                    <p><i class="far fa-list-alt"></i> Food</p>
                                    <p><i class="far fa-calendar-alt"></i> <?= Yii::$app->formatter->asDate($blog->published_at, 'php:d-M-Y') ?></p>
                                </div>
                                <div class="blog-text">
                                    <p>
                                        <?= Html::encode(StringHelper::truncateWords(strip_tags($blog->content), 25)) ?>
                                    </p>
                                    <a class="btn custom-btn" href="<?= Url::to(['site/blog-details', 'id' => $blog->id]) ?>">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>No blog posts found.</p>
                </div>
            <?php endif; ?>
        </div>
        
        </div>
</div>