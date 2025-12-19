<?php

use dashboard\models\Banners;
use helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;

/** @var yii\web\View $this */
/** @var dashboard\models\search\BannersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Banners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banners-index row">
    <div class="col-md-12">
        <div class="block block-rounded">
            
            <div class="block-header block-header-default">
                <h3 class="block-title"><?= Html::encode($this->title) ?> </h3>
                <div class="block-options">
                    <?= Html::customButton([
                        'type' => 'modal',
                        'url' => Url::to(['create']),
                        'appearence' => [
                            'size' => 'lg',
                            'type' => 'text',
                            'text' => 'Add Banner',
                            'theme' => 'primary',
                            'icon' => 'plus', // Added icon for flair
                            'visible' => Yii::$app->user->can('dashboard-banner-create', true)
                        ],
                        'modal' => [
                            'size' => 'lg',
                            'title' => 'New Banner'
                        ]
                    ]) ?>
                </div>
            </div>

            <div class="block-content">
                <div class="banners-search my-3">
                    <?= $this->render('_search', ['model' => $searchModel]); ?>
                </div>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-hover table-vcenter'], // Clean OneUI table style
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                      

                        // --- 2. TITLE ---
                        [
                            'attribute' => 'title',
                            'contentOptions' => ['class' => 'fw-semibold'],
                        ],

                        // --- 3. CONTENT (Truncated) ---
                        [
                            'attribute' => 'content',
                            'format' => 'ntext',
                            'contentOptions' => ['style' => 'max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #6c757d;'],
                        ],

                        // --- 4. STATUS TOGGLE ---
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'label' => 'Status',
                            'filter' => [1 => 'Active', 0 => 'Draft'],
                            'contentOptions' => ['class' => 'text-center', 'style' => 'width: 100px;'],
                            'value' => function ($model) {
                                $isActive = $model->status === 1;
                                $iconClass = $isActive ? 'fa fa-toggle-on fa-2x text-success' : 'fa fa-toggle-off fa-2x text-muted';
                                $title = $isActive ? 'Published' : 'Draft';
                                
                                return Html::a(
                                    '<i class="' . $iconClass . '"></i>',
                                    Url::to(['status', 'id' => $model->id]),
                                    [
                                        'title' => $title,
                                        'data-pjax' => '0',
                                        'data-method' => 'post',
                                    ]
                                );
                            }
                        ],
     [
                            'attribute' => 'image_link',
                            'label' => 'Image Preview',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width: 120px; text-align: center;'],
                            'value' => function ($model) {
                                if (empty($model->image_link)) {
                                    return '<span class="badge bg-secondary">No Image</span>';
                                }
                                $url = Yii::getAlias('@web/') . $model->image_link;
                                
                                return Html::a(
                                    Html::img($url, ['class' => 'img-fluid rounded shadow-sm', 'style' => 'height: 50px; width: auto; object-fit: cover;']),
                                    '#', 
                                    [
                                        'data-bs-toggle' => 'modal',
                                        'data-bs-target' => '#modal-banner-preview',
                                        'data-src' => $url, // Pass URL to modal
                                        'title' => 'Click to enlarge',
                                        'class' => 'd-inline-block'
                                    ]
                                );
                            }
                        ],
                        // --- 5. ACTIONS ---
                        [
                            'class' => \helpers\grid\ActionColumn::className(),
                            'template' => '{update} {trash}',
                            'headerOptions' => ['width' => '10%'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return Html::customButton([
                                        'type' => 'modal', 
                                        'url' => Url::toRoute(['update', 'id' => $model->id]), 
                                        'modal' => ['title' => 'Update Banner', 'size' => 'lg'], 
                                        'appearence' => ['icon' => 'edit', 'theme' => 'info']
                                    ]);
                                },
                                'trash' => function ($url, $model, $key) {
                                    return $model->is_deleted !== 1 ?
                                        Html::customButton([
                                            'type' => 'link', 
                                            'url' => Url::toRoute(['trash', 'id' => $model->id]), 
                                            'appearence' => ['icon' => 'trash', 'theme' => 'danger', 'data' => ['message' => 'Do you want to delete this banner?']]
                                        ]) :
                                        Html::customButton([
                                            'type' => 'link', 
                                            'url' => Url::toRoute(['trash', 'id' => $model->id]), 
                                            'appearence' => ['icon' => 'undo', 'theme' => 'warning', 'data' => ['message' => 'Do you want to restore this banner?']]
                                        ]);
                                },
                            ],
                            'visibleButtons' => [
                                'update' => Yii::$app->user->can('dashboard-banner-update', true),
                                'trash' => function ($model) {
                                    return $model->is_deleted !== 1 ?
                                        Yii::$app->user->can('dashboard-banner-delete', true) :
                                        Yii::$app->user->can('dashboard-banner-restore', true);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-banner-preview" tabindex="-1" aria-labelledby="modal-banner-preview" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent shadow-none border-0">
            <div class="modal-body text-center p-0 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" 
                        data-bs-dismiss="modal" aria-label="Close" 
                        style="z-index: 10; background-color: rgba(0,0,0,0.5); border-radius: 50%; padding: 10px;"></button>
                
                <img id="preview-modal-img" src="" alt="Banner Preview" class="img-fluid rounded shadow-lg" style="max-height: 85vh;">
            </div>
        </div>
    </div>
</div>

<?php
// JAVASCRIPT: Handles swapping the image source when Modal opens
$script = <<< JS
    var previewModal = document.getElementById('modal-banner-preview');
    previewModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget;
        // Extract info from data-src attribute
        var imageUrl = button.getAttribute('data-src');
        // Update the modal's content
        var modalImg = previewModal.querySelector('#preview-modal-img');
        modalImg.src = imageUrl;
    });
JS;
$this->registerJs($script);
?>