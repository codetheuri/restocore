<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var dashboard\models\Blogs $blog */

$this->title = $blog->title;
?>

<?= $this->render('@ui/views/components/cynefinblogs/breadcrumbs', ['title' => $blog->title]) ?>

<div class="single-blog"> <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="blog-item">
                    
                    <div class="blog-img mb-4">
                        <?php 
                            $imgUrl = !empty($blog->image_link) ? '@web/' . $blog->image_link : '@web/providers/interface/assets/assets/img/blog-1.jpg';
                            echo Html::img($imgUrl, ['alt' => $blog->title, 'class' => 'img-fluid rounded', 'style' => 'width: 100%; max-height: 500px; object-fit: cover;']); 
                        ?>
                    </div>

                    <div class="blog-content p-4 bg-white shadow-sm rounded">
                        
                        <h1 class="mb-3"><?= Html::encode($blog->title) ?></h1>
                        
                        <div class="blog-meta mb-4 pb-3 border-bottom">
                            <span class="me-3"><i class="far fa-user me-1"></i> Admin</span>
                            <span class="me-3"><i class="far fa-calendar-alt me-1"></i> <?= Yii::$app->formatter->asDate($blog->published_at, 'long') ?></span>
                            <span><i class="far fa-folder me-1"></i> Food & Recipes</span>
                        </div>

                        <div class="blog-text">
                            <?= Yii::$app->formatter->asHtml($blog->content) ?>
                        </div>

                        <div class="mt-5 pt-4 border-top d-flex justify-content-between align-items-center">
                            <a href="<?= Url::to(['site/blog']) ?>" class="btn custom-btn">
                                <i class="fa fa-arrow-left me-1"></i> Back to Blogs
                            </a>
                            
                            <div class="social-share">
                                <span class="me-2 fw-bold">Share:</span>
                                <a href="#" class="text-primary me-2"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="text-info me-2"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-danger"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .single-blog { padding: 45px 0; }
    .blog-text p { font-size: 16px; line-height: 1.8; color: #666; margin-bottom: 20px; }
    .blog-text h2, .blog-text h3 { margin-top: 30px; margin-bottom: 15px; color: #333; }
    .blog-text ul, .blog-text ol { margin-bottom: 20px; padding-left: 20px; }
</style>