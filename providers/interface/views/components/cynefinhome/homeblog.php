<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;

/** @var dashboard\models\Blogs[] $blogs */
?>

<?php if (!empty($blogs)): ?>
<div class="blog">
    <div class="container">
        <div class="section-header text-center">
            <p>News & Stories</p>
            <h2>Latest From Our Kitchen</h2>
        </div>
        
        <div class="row">
            <?php foreach ($blogs as $blog): ?>
                <div class="col-md-6">
                    <div class="blog-item">
                        
                        <div class="blog-img">
                            <?php 
                                $imgUrl = !empty($blog->image_link) ? '@web/' . $blog->image_link : '@web/providers/interface/assets/assets/img/blog-1.jpg';
                                // Used Url::to inside Html::a to link the image too
                                echo Html::a(
                                    Html::img($imgUrl, [
                                        'alt' => $blog->title, 
                                        'style' => 'width: 100%; height: 250px; object-fit: cover;' // Force clean aspect ratio
                                    ]),
                                    ['site/blog-details', 'id' => $blog->id]
                                ); 
                            ?>
                        </div>

                        <div class="blog-content">
                            <h2 class="blog-title">
                                <a href="<?= Url::to(['site/blog-details', 'id' => $blog->id]) ?>" class="text-dark text-decoration-none">
                                    <?= Html::encode($blog->title) ?>
                                </a>
                            </h2>
                            
                            <div class="blog-meta">
                                <p><i class="far fa-user"></i> Admin</p>
                                <p><i class="far fa-calendar-alt"></i> <?= Yii::$app->formatter->asDate($blog->published_at, 'php:d M Y') ?></p>
                            </div>
                            
                            <div class="blog-text">
                                <p>
                                    <?= Html::encode(StringHelper::truncateWords(strip_tags($blog->content), 20)) ?>
                                </p>
                                <a class="btn custom-btn" href="<?= Url::to(['site/blog-details', 'id' => $blog->id]) ?>">
                                    Read Story <i class="fa fa-arrow-right ms-2 fs-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="<?= Url::to(['site/blog']) ?>" class="btn custom-btn" style="padding: 12px 30px; font-weight: bold;">
                    View All Stories
                </a>
            </div>
        </div>

    </div>
</div>
<?php endif; ?>