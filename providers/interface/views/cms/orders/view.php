<?php

use helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var restaurant\models\Orders $model */

$this->title = 'Order #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">
    <div class="row">
        <!-- Main Order Details -->
        <div class="col-md-8">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Order Items</h3>
                </div>
                <div class="block-content">
                    <table class="table table-bordered table-vcenter">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-center" style="width: 100px;">Qty</th>
                                <th class="text-end" style="width: 150px;">Unit Price</th>
                                <th class="text-end" style="width: 150px;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($model->items as $item): ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold"><?= Html::encode($item->menu->name ?? 'Deleted Item') ?></div>
                                        <div class="text-muted fs-sm"><?= Html::encode($item->menu->category->name ?? '') ?></div>
                                    </td>
                                    <td class="text-center"><?= $item->quantity ?></td>
                                    <td class="text-end">KES <?= number_format($item->unit_price, 2) ?></td>
                                    <td class="text-end fw-bold">KES <?= number_format($item->subtotal, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <td colspan="3" class="text-end fw-bold">TOTAL</td>
                                <td class="text-end fw-bold fs-lg">KES <?= number_format($model->total_amount, 2) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Delivery & Notes</h3>
                </div>
                <div class="block-content pb-3">
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="fw-bold mb-1">Delivery Address:</p>
                            <p class="text-muted"><?= nl2br(Html::encode($model->delivery_address)) ?: 'No address provided' ?></p>
                        </div>
                        <div class="col-sm-6">
                            <p class="fw-bold mb-1">Customer Phone:</p>
                            <p class="text-muted"><?= Html::encode($model->phone_number) ?: 'No phone provided' ?></p>
                        </div>
                    </div>
                    <?php if ($model->notes): ?>
                        <div class="mt-2">
                            <p class="fw-bold mb-1">Order Notes:</p>
                            <div class="alert alert-warning py-2 mb-0">
                                <?= nl2br(Html::encode($model->notes)) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions & Info -->
        <div class="col-md-4">
            <!-- Order Status Management -->
            <div class="block block-rounded">
                <div class="block-header block-header-default bg-dark">
                    <h3 class="block-title text-white">Manage Status</h3>
                </div>
                <div class="block-content">
                    <div class="mb-4 text-center">
                        <p class="mb-2">Current Status:</p>
                        <?php
                            $class = 'bg-secondary';
                            switch ($model->status) {
                                case 'pending': $class = 'bg-warning text-dark'; break;
                                case 'preparing': $class = 'bg-info'; break;
                                case 'ready': $class = 'bg-primary'; break;
                                case 'delivered': $class = 'bg-success'; break;
                                case 'cancelled': $class = 'bg-danger'; break;
                            }
                        ?>
                        <span class="badge <?= $class ?> fs-6 p-2 w-100"><?= strtoupper(str_replace('_', ' ', $model->status)) ?></span>
                    </div>

                    <div class="d-grid gap-2 mb-4">
                        <?php if ($model->status === 'pending'): ?>
                            <?= Html::a('Accept (Preparing)', ['update-status', 'id' => $model->id, 'status' => 'preparing'], ['class' => 'btn btn-alt-info', 'data-method' => 'post']) ?>
                        <?php endif; ?>
                        
                        <?php if ($model->status === 'preparing'): ?>
                            <?= Html::a('Mark as Ready', ['update-status', 'id' => $model->id, 'status' => 'ready'], ['class' => 'btn btn-alt-primary', 'data-method' => 'post']) ?>
                        <?php endif; ?>

                        <?php if ($model->status === 'ready'): ?>
                            <?= Html::a('Out for Delivery', ['update-status', 'id' => $model->id, 'status' => 'out_for_delivery'], ['class' => 'btn btn-alt-info', 'data-method' => 'post']) ?>
                        <?php endif; ?>

                        <?php if ($model->status === 'out_for_delivery'): ?>
                            <?= Html::a('Confirm Delivered', ['update-status', 'id' => $model->id, 'status' => 'delivered'], ['class' => 'btn btn-alt-success', 'data-method' => 'post']) ?>
                        <?php endif; ?>

                        <?php if (!in_array($model->status, ['delivered', 'cancelled'])): ?>
                            <hr>
                            <?= Html::a('Cancel Order', ['update-status', 'id' => $model->id, 'status' => 'cancelled'], [
                                'class' => 'btn btn-alt-danger btn-sm', 
                                'data-method' => 'post',
                                'data-confirm' => 'Are you sure you want to cancel this order?'
                            ]) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Payment Info</h3>
                </div>
                <div class="block-content">
                    <p class="mb-1">Method: <span class="fw-bold"><?= strtoupper($model->payment_method ?: 'Not specified') ?></span></p>
                    <p class="mb-3">Status: <span class="badge <?= ($model->payment_status === 'paid') ? 'bg-success' : 'bg-danger' ?>"><?= strtoupper($model->payment_status) ?></span></p>
                    
                    <?php if ($model->payment_status !== 'paid'): ?>
                        <?= Html::a('Mark as Paid', ['update-payment', 'id' => $model->id, 'status' => 'paid'], ['class' => 'btn btn-success btn-sm w-100', 'data-method' => 'post']) ?>
                    <?php else: ?>
                        <?= Html::a('Mark as Unpaid', ['update-payment', 'id' => $model->id, 'status' => 'unpaid'], ['class' => 'btn btn-outline-danger btn-sm w-100', 'data-method' => 'post']) ?>
                    <?php endif; ?>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light fs-sm text-center">
                    Placed on <?= date('d M Y \a\t H:i', $model->created_at) ?>
                </div>
            </div>
        </div>
    </div>
</div>
