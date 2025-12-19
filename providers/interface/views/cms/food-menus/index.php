<?php

use dashboard\models\FoodMenus;
use helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;

/** @var yii\web\View $this */
/** @var dashboard\models\search\FoodMenusSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Food Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-menus-index row">
    <div class="col-md-12">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title"><?= Html::encode($this->title) ?> </h3>
                <div class="block-options">
                    <?= Html::a('<i class="fa fa-plus me-1"></i> Add Menu Item', ['create'], ['class' => 'btn btn-primary']) ?>
                </div> 
            </div>
            
            <div class="block-content">     
                <div class="food-menus-search my-3">
                    <?= $this->render('_search', ['model' => $searchModel]); ?>
                </div>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-hover table-vcenter'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 1. IMAGE THUMBNAIL (Now Clickable)
                        [
                            'attribute' => 'image',
                            'label' => '',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width: 100px; text-align: center;'],
                            'value' => function ($model) {
                                $url = !empty($model->image) ? Yii::getAlias('@web/') . $model->image : null;
                                
                                // Placeholder if no image
                                if (!$url) {
                                    return Html::img('https://via.placeholder.com/100x80?text=No+Img', ['class' => 'img-fluid rounded shadow-sm', 'style' => 'height: 60px; width: 80px; object-fit: cover; opacity: 0.6;']);
                                }

                                // Clickable Image
                                return Html::a(
                                    Html::img($url, ['class' => 'img-fluid rounded shadow-sm', 'style' => 'height: 60px; width: 80px; object-fit: cover;']),
                                    '#', 
                                    [
                                        'data-bs-toggle' => 'modal',
                                        'data-bs-target' => '#modal-menu-preview',
                                        'data-src' => $url,
                                        'title' => 'View Full Image'
                                    ]
                                );
                            }
                        ],

                        // 2. NAME & CATEGORY
                        [
                            'attribute' => 'name',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $catName = $model->category ? $model->category->name : 'Uncategorized';
                                return "
                                <div class='fw-bold text-dark fs-6'>{$model->name}</div>
                                <span class='badge bg-body-dark text-dark fw-normal mt-1'>{$catName}</span>
                                ";
                            }
                        ],

                        // 3. PRICE
                        [
                            'attribute' => 'price',
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'fw-bold'],
                            'value' => function ($model) {
                                return 'KES ' . number_format($model->price, 2);
                            }
                        ],

                        // 4. STOCK AVAILABILITY
                        [
                            'attribute' => 'is_available',
                            'label' => 'Stock',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'value' => function ($model) {
                                if ($model->is_available) {
                                    return '<span class="badge bg-success">In Stock</span>';
                                }
                                return '<span class="badge bg-danger">Sold Out</span>';
                            }
                        ],

                        // 5. STATUS TOGGLE
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'label' => 'Visibility',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'value' => function ($model) {
                                $isActive = $model->status === 1;
                                $icon = $isActive ? 'fa-toggle-on text-success' : 'fa-toggle-off text-muted';
                                return Html::a(
                                    '<i class="fa ' . $icon . ' fa-2x"></i>',
                                    Url::to(['status', 'id' => $model->id]),
                                    ['data-method' => 'post', 'data-pjax' => '0']
                                );
                            }
                        ],

                        // 6. ACTIONS
                        [
                            'class' => \helpers\grid\ActionColumn::className(),
                            'template' => '{update} {trash}',
                            'headerOptions' => ['width' => '100px'],
                            'contentOptions' => ['class' => 'text-center'],
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    return Html::a('<i class="fa fa-pen"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-alt-info']);
                                },
                                'trash' => function ($url, $model) {
                                    $isDel = $model->is_deleted;
                                    return Html::a(
                                        '<i class="fa ' . ($isDel ? 'fa-undo' : 'fa-trash') . '"></i>', 
                                        ['trash', 'id' => $model->id], 
                                        [
                                            'class' => 'btn btn-sm ' . ($isDel ? 'btn-alt-warning' : 'btn-alt-danger') . ' ms-1',
                                            'data-method' => 'post'
                                        ]
                                    );
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-menu-preview" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent shadow-none border-0">
            <div class="modal-body text-center p-0 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" 
                        data-bs-dismiss="modal" aria-label="Close" 
                        style="z-index: 10; background-color: rgba(0,0,0,0.5); border-radius: 50%; padding: 10px;"></button>
                <img id="menu-preview-img" src="" class="img-fluid rounded shadow-lg" style="max-height: 85vh;">
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
    var menuModal = document.getElementById('modal-menu-preview');
    menuModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var imageUrl = button.getAttribute('data-src');
        var modalImg = menuModal.querySelector('#menu-preview-img');
        modalImg.src = imageUrl;
    });
JS;
$this->registerJs($script);
?>