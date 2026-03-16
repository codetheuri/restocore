<?php

use helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;

/** @var yii\web\View $this */
/** @var iam\models\User $model */
/** @var yii\data\ActiveDataProvider $orderDataProvider */

$this->title = $model->profile->full_name ?? $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view">
    <div class="row">
        <!-- Profile Info -->
        <div class="col-md-4">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Customer Profile</h3>
                </div>
                <div class="block-content text-center pb-4">
                    <div class="mb-3">
                        <div class="d-inline-block p-3 bg-body-dark rounded-circle">
                            <i class="fa fa-user fa-3x text-primary"></i>
                        </div>
                    </div>
                    <h2 class="h4 fw-bold mb-1"><?= Html::encode($this->title) ?></h2>
                    <p class="text-muted small">@<?= Html::encode($model->username) ?></p>
                    
                    <ul class="list-group list-group-flush text-start">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Email:</span>
                            <span class="fw-semibold"><?= Html::encode($model->profile->email_address) ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Phone:</span>
                            <span class="fw-semibold"><?= Html::encode($model->profile->mobile_number) ?></span>
                        </li>
                        <li class="list-group-item px-0">
                            <span class="text-muted d-block mb-1">Default Address:</span>
                            <div class="alert alert-secondary py-2 mb-0 fs-sm">
                                <?= nl2br(Html::encode($model->profile->physical_address)) ?: 'No address saved.' ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Order History -->
        <div class="col-md-8">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Order History</h3>
                </div>
                <div class="block-content">
                    <?= GridView::widget([
                        'dataProvider' => $orderDataProvider,
                        'tableOptions' => ['class' => 'table table-vcenter'],
                        'columns' => [
                            [
                                'attribute' => 'id',
                                'label' => 'Order ID',
                                'format' => 'raw',
                                'value' => function($order) {
                                    return Html::a('#' . $order->id, ['/dashboard/order/view', 'id' => $order->id], ['class' => 'fw-bold']);
                                }
                            ],
                            [
                                'attribute' => 'total_amount',
                                'value' => function($order) {
                                    return 'KES ' . number_format($order->total_amount, 2);
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'value' => function($order) {
                                    $class = 'bg-secondary';
                                    switch ($order->status) {
                                        case 'delivered': $class = 'bg-success'; break;
                                        case 'cancelled': $class = 'bg-danger'; break;
                                        case 'pending': $class = 'bg-warning text-dark'; break;
                                    }
                                    return "<span class='badge {$class}'>" . ucfirst($order->status) . "</span>";
                                }
                            ],
                            [
                                'attribute' => 'created_at',
                                'label' => 'Date',
                                'value' => function($order) {
                                    return date('M d, Y', $order->created_at);
                                }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
