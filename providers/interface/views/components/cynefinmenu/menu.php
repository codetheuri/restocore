<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;

/** @var dashboard\models\MenuCategories[] $categories */

// Icons for the top section (just for visual variety)
$icons = ['flaticon-burger', 'flaticon-snack', 'flaticon-cocktail', 'flaticon-pizza', 'flaticon-bread'];
?>

<div class="food">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <?php 
            // Take the first 3 categories for this highlight section
            $topThree = array_slice($categories, 0, 3);
            $i = 0;
            foreach ($topThree as $cat): 
                // Cycle through icons safely
                $iconClass = $icons[$i % count($icons)];
                $i++;
            ?>
                <div class="col-md-4">
                    <div class="food-item">
                        <i class="<?= $iconClass ?>"></i>
                        <h2><?= Html::encode($cat->name) ?></h2>
                        <p>
                            <?= Html::encode(StringHelper::truncate($cat->description, 80)) ?>
                        </p>
                        <a href="#menu-section" onclick="$('#tab-link-<?= $cat->id ?>').click();">View Items</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="menu" id="menu-section">
    <div class="container">
        <div class="section-header text-center">
            <p>Cynefin Diner Menu</p>
            <h2>Delicious Food for Every Taste</h2>
        </div>
        
        <div class="menu-tab">
            <ul class="nav nav-pills justify-content-center">
                <?php 
                $isFirst = true;
                foreach ($categories as $cat): 
                ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $isFirst ? 'active' : '' ?>" 
                           id="tab-link-<?= $cat->id ?>"
                           data-toggle="pill" 
                           href="#category-<?= $cat->id ?>">
                           <?= Html::encode($cat->name) ?>
                        </a>
                    </li>
                <?php 
                    $isFirst = false; 
                endforeach; 
                ?>
            </ul>

            <div class="tab-content">
                <?php 
                $isFirstPane = true;
                foreach ($categories as $cat): 
                    // Get first image of this category for the large side image
                    $firstItemImg = !empty($cat->foodMenuses[0]->image) 
                        ? '@web/' . $cat->foodMenuses[0]->image 
                        : '@web/providers/interface/assets/assets/img/menu-burger.jpg'; // Fallback
                ?>
                    <div id="category-<?= $cat->id ?>" class="container tab-pane <?= $isFirstPane ? 'active' : 'fade' ?>">
                        <div class="row">
                            
                            <div class="col-lg-7 col-md-12">
                                <?php foreach ($cat->foodMenuses as $food): ?>
                                    <div class="menu-item">
                                        <div class="menu-img">
                                            <?php 
                                            $foodImg = !empty($food->image) ? '@web/' . $food->image : '@web/providers/interface/assets/assets/img/menu-burger.jpg';
                                            echo Html::img($foodImg, ['alt' => $food->name]); 
                                            ?>
                                        </div>
                                        <div class="menu-text">
                                            <h3>
                                                <span><?= Html::encode($food->name) ?></span> 
                                                <strong><?= number_format($food->price) ?> UGX</strong>
                                            </h3>
                                            <p><?= Html::encode(StringHelper::truncate(strip_tags($food->description), 60)) ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="col-lg-5 d-none d-lg-block">
                                <?= Html::img($firstItemImg, [
                                    'alt' => $cat->name, 
                                    'class' => 'img-fluid rounded', 
                                    'style' => 'width: 100%; height: 100%; object-fit: cover; max-height: 600px;'
                                ]); ?>
                            </div>

                        </div>
                    </div>
                <?php 
                    $isFirstPane = false;
                endforeach; 
                ?>
            </div>
        </div>
    </div>
</div>