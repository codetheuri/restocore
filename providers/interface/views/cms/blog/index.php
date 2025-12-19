<?php

use dashboard\models\Blogs;
use helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var dashboard\models\search\BlogsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Blog Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blogs-index row">
    <div class="col-md-12">
        <div class="block block-rounded">
            
            <div class="block-header block-header-default">
                <h3 class="block-title"><?= Html::encode($this->title) ?></h3>
                <div class="block-options">
                    <?= Html::a(
                        '<i class="fa fa-plus me-1"></i> Write New Post',
                        ['create'],
                        ['class' => 'btn btn-primary']
                    ) ?>
                </div>
            </div>

            <div class="block-content">
                <div class="blogs-search my-3">
                    <?= $this->render('_search', ['model' => $searchModel]); ?>
                </div>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-hover table-vcenter'], // Clean alignment
                    'summary' => '<div class="text-muted fs-sm pb-2">Showing {begin}-{end} of {totalCount} posts</div>',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        
                        // 1. IMAGE THUMBNAIL (Triggers Modal)
                        [
                            'attribute' => 'image_link',
                            'label' => '',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width: 120px; min-width:120px; text-align: center;'],
                            'value' => function ($model) {
                                if (empty($model->image_link)) {
                                    // Placeholder for no image
                                    return '<div class="bg-body-dark rounded d-flex align-items-center justify-content-center" style="height: 80px; width: 100%; color: #999;"><i class="fa fa-image fa-2x"></i></div>';
                                }
                                $url = Yii::getAlias('@web/') . $model->image_link;
                                
                                return Html::a(
                                    Html::img($url, ['class' => 'img-fluid rounded shadow-sm', 'style' => 'height: 80px; width: 100%; object-fit: cover;']),
                                    '#', 
                                    [
                                        'data-bs-toggle' => 'modal',
                                        'data-bs-target' => '#modal-blog-preview',
                                        'data-src' => $url,
                                        'title' => 'View Cover Image'
                                    ]
                                );
                            }
                        ],

                        // 2. RICH CONTENT COLUMN (Title + Excerpt + Meta)
                        [
                            'attribute' => 'title',
                            'label' => 'Article Details',
                            'format' => 'raw',
                            'value' => function ($model) {
                                // 1. Title
                                $title = Html::encode($model->title);
                                
                                // 2. Excerpt (Strip HTML tags from Quill, truncate to 20 words)
                                $excerpt = StringHelper::truncateWords(strip_tags($model->content), 20);
                                
                                // 3. Meta Data (Date)
                                $date = $model->published_at ? Yii::$app->formatter->asDate($model->published_at, 'medium') : 'Not scheduled';
                                
                                return "
                                <div class='py-1'>
                                    <a href='" . Url::to(['update', 'id' => $model->id]) . "' class='fw-bold text-dark fs-5 text-decoration-none'>$title</a>
                                    <p class='text-muted fs-sm mb-1 mt-1'>$excerpt</p>
                                    <div class='fs-xs text-muted'>
                                        <i class='fa fa-calendar-alt me-1'></i> $date
                                    </div>
                                </div>";
                            }
                        ],

                        // 3. STATUS TOGGLE
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'label' => 'Status',
                            'filter' => [1 => 'Published', 0 => 'Draft'],
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center', 'style' => 'width: 100px;'],
                            'value' => function ($model) {
                                $isActive = $model->status === 1;
                                $iconClass = $isActive ? 'fa fa-toggle-on fa-2x text-success' : 'fa fa-toggle-off fa-2x text-muted';
                                $title = $isActive ? 'Published (Click to draft)' : 'Draft (Click to publish)';
                                
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

                        // 4. ACTIONS
                        [
                            'class' => \helpers\grid\ActionColumn::className(),
                            'template' => '{update} {trash}',
                            'headerOptions' => ['width' => '100px'],
                            'contentOptions' => ['class' => 'text-center'],
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    // Using standard link for update since we aren't using modals for the form anymore
                                    return Html::a('<i class="fa fa-pen"></i>', ['update', 'id' => $model->id], [
                                        'class' => 'btn btn-sm btn-alt-info',
                                        'title' => 'Edit Post',
                                        'data-pjax' => '0'
                                    ]);
                                },
                                'trash' => function ($url, $model, $key) {
                                    $isDeleted = $model->is_deleted === 1;
                                    $icon = $isDeleted ? 'fa fa-undo' : 'fa fa-trash';
                                    $theme = $isDeleted ? 'btn-alt-warning' : 'btn-alt-danger';
                                    $msg = $isDeleted ? 'Restore this post?' : 'Move to trash?';
                                    
                                    return Html::a('<i class="' . $icon . '"></i>', ['trash', 'id' => $model->id], [
                                        'class' => 'btn btn-sm ' . $theme . ' ms-1',
                                        'title' => $isDeleted ? 'Restore' : 'Delete',
                                        'data-method' => 'post',
                                        'data-confirm' => $msg
                                    ]);
                                },
                            ],
                            // Keep your existing permissions logic here
                            'visibleButtons' => [
                                'update' => Yii::$app->user->can('dashboard-blog-update', true),
                                'trash' => function ($model) {
                                    return $model->is_deleted !== 1 ?
                                        Yii::$app->user->can('dashboard-blog-delete', true) :
                                        Yii::$app->user->can('dashboard-blog-restore', true);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-blog-preview" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent shadow-none border-0">
            <div class="modal-body text-center p-0 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" 
                        data-bs-dismiss="modal" aria-label="Close" 
                        style="z-index: 10; background-color: rgba(0,0,0,0.5); border-radius: 50%; padding: 10px;"></button>
                <img id="blog-preview-img" src="" class="img-fluid rounded shadow-lg" style="max-height: 85vh;">
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
    var blogModal = document.getElementById('modal-blog-preview');
    blogModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var imageUrl = button.getAttribute('data-src');
        var modalImg = blogModal.querySelector('#blog-preview-img');
        modalImg.src = imageUrl;
    });
JS;
$this->registerJs($script);
?>