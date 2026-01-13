<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;

/** @var dashboard\models\MenuCategories[] $categories */

// Icon rotation to keep visuals interesting
$icons = ['flaticon-burger', 'flaticon-snack', 'flaticon-cocktail'];
?>

<?php if (!empty($categories)): ?>
<div class="food">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            
            <?php 
            $i = 0;
            foreach ($categories as $cat): 
                // Cycle through the 3 icons
                $currentIcon = $icons[$i % count($icons)];
                $i++;
            ?>
                <div class="col-md-4">
                    <div class="food-item">
                        <i class="<?= $currentIcon ?>"></i>
                        <h2><?= Html::encode($cat->name) ?></h2>
                        <p>
                            <?= Html::encode(StringHelper::truncate($cat->description, 90)) ?>
                        </p>
                        
                        <a href="<?= Url::to(['site/menu']) ?>">View Items</a>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>
<?php endif; ?>