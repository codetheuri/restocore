<?php

use dashboard\models\MenuCategories;
use helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var dashboard\models\search\MenuCategoriesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Menu Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-categories-index row">
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
                            'text' => 'Add Category',
                            'theme' => 'primary',
                            'icon' => 'plus',
                            'visible' => Yii::$app->user->can('dashboard-menu-category-create', true)
                        ],
                        'modal' => [
                            'size' => 'lg',
                            'title' => 'New Menu Category'
                        ]
                    ]) ?>
                </div> 
            </div>

            <div class="block-content">     
                <div class="menu-categories-search my-3">
                    <?= $this->render('_search', ['model' => $searchModel]); ?>
                </div>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-hover table-vcenter'], // Clean OneUI Style
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 1. NAME (Bold)
                        [
                            'attribute' => 'name',
                            'contentOptions' => ['class' => 'fw-semibold fs-sm'],
                        ],

                        // 2. DESCRIPTION (Truncated)
                        [
                            'attribute' => 'description',
                            'value' => function ($model) {
                                return StringHelper::truncate($model->description, 50);
                            },
                            'contentOptions' => ['class' => 'text-muted fs-sm'],
                        ],

                        // 3. DISPLAY ORDER (Optional but good to see)
                        // [
                        //     'attribute' => 'display_order',
                        //     'label' => 'Order',
                        //     'headerOptions' => ['class' => 'text-center', 'style' => 'width: 80px;'],
                        //     'contentOptions' => ['class' => 'text-center'],
                        //     'value' => function($model) {
                        //         return '<span class="badge bg-body-dark text-dark">#' . $model->display_order . '</span>';
                        //     },
                        //     'format' => 'raw'
                        // ],

                        // 4. STATUS TOGGLE
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'label' => 'Status',
                            'filter' => [1 => 'Visible', 0 => 'Hidden'],
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center', 'style' => 'width: 100px;'],
                            'value' => function ($model) {
                                $isActive = $model->status === 1;
                                $iconClass = $isActive ? 'fa fa-toggle-on fa-2x text-success' : 'fa fa-toggle-off fa-2x text-muted';
                                $title = $isActive ? 'Visible' : 'Hidden';
                                
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

                        // 5. ACTIONS
                        [
                            'class' => \helpers\grid\ActionColumn::className(),
                            'template' => '{update} {trash}',
                            'headerOptions' => ['width' => '100px'],
                            'contentOptions' => ['class' => 'text-center'],
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return Html::customButton([
                                        'type' => 'modal', 
                                        'url' => Url::toRoute(['update', 'id' => $model->id]), 
                                        'modal' => ['title' => 'Update Category', 'size'=>'lg'], 
                                        'appearence' => ['icon' => 'edit', 'theme' => 'info']
                                    ]);
                                },
                                'trash' => function ($url, $model, $key) {
                                    return $model->is_deleted !== 1 ?
                                        Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]), 'appearence' => ['icon' => 'trash', 'theme' => 'danger', 'data' => ['message' => 'Delete this category?']]]) :
                                        Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]), 'appearence' => ['icon' => 'undo', 'theme' => 'warning', 'data' => ['message' => 'Restore this category?']]]);
                                },
                            ],
                            'visibleButtons' => [
                                'update' => Yii::$app->user->can('dashboard-menu-category-update', true),
                                'trash' => function ($model){
                                     return $model->is_deleted !== 1 ? 
                                            Yii::$app->user->can('dashboard-menu-category-delete', true) : 
                                            Yii::$app->user->can('dashboard-menu-category-restore', true);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>