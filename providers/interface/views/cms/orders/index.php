<?php

use restaurant\models\Orders;
use helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;

/** @var yii\web\View $this */
/** @var dashboard\models\search\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Manage Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index row">
    <div class="col-md-12">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title"><?= Html::encode($this->title) ?> </h3>
            </div>
            
            <div class="block-content">     
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-hover table-vcenter'],
                    'columns' => [
                        ['attribute' => 'id', 'label' => '#ID', 'contentOptions' => ['width' => '80px']],
                        [
                            'attribute' => 'user_id',
                            'label' => 'Customer',
                            'value' => function ($model) {
                                return $model->user ? ($model->user->profile->full_name ?? $model->user->username) : 'Unknown';
                            }
                        ],
                        [
                            'attribute' => 'total_amount',
                            'value' => function ($model) {
                                return 'KES ' . number_format($model->total_amount, 2);
                            },
                            'contentOptions' => ['class' => 'fw-bold'],
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'filter' => [
                                'pending' => 'Pending',
                                'preparing' => 'Preparing',
                                'ready' => 'Ready',
                                'out_for_delivery' => 'Out for Delivery',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                            ],
                            'value' => function ($model) {
                                $class = 'bg-secondary';
                                switch ($model->status) {
                                    case 'pending': $class = 'bg-warning text-dark'; break;
                                    case 'preparing': $class = 'bg-info'; break;
                                    case 'ready': $class = 'bg-primary'; break;
                                    case 'delivered': $class = 'bg-success'; break;
                                    case 'cancelled': $class = 'bg-danger'; break;
                                }
                                return "<span class='badge {$class}'>" . ucfirst(str_replace('_', ' ', $model->status)) . "</span>";
                            }
                        ],
                        [
                            'attribute' => 'payment_status',
                            'format' => 'raw',
                            'filter' => ['unpaid' => 'Unpaid', 'paid' => 'Paid', 'failed' => 'Failed'],
                            'value' => function ($model) {
                                $class = ($model->payment_status === 'paid') ? 'text-success' : 'text-danger';
                                return "<span class='fw-bold {$class}'>" . strtoupper($model->payment_status) . "</span>";
                            }
                        ],
                        [
                            'attribute' => 'created_at',
                            'label' => 'Date',
                            'value' => function ($model) {
                                return date('M d, H:i', $model->created_at);
                            }
                        ],
                        [
                            'class' => \helpers\grid\ActionColumn::className(),
                            'template' => '{view} {delete}',
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    return Html::a('<i class="fa fa-eye"></i>', ['view', 'id' => $model->id], ['class' => 'btn btn-sm btn-alt-secondary']);
                                },
                                'delete' => function ($url, $model) {
                                    return Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
                                        'class' => 'btn btn-sm btn-alt-danger',
                                        'data-confirm' => 'Are you sure you want to delete this order?',
                                        'data-method' => 'post',
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
