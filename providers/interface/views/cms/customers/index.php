<?php

use helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;

/** @var yii\web\View $this */
/** @var dashboard\models\search\CustomerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Resto Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index row">
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
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'full_name',
                            'label' => 'Customer Name',
                            'value' => function ($model) {
                                return $model->profile->full_name ?? $model->username;
                            }
                        ],
                        [
                            'attribute' => 'email_address',
                            'label' => 'Email',
                            'value' => 'profile.email_address'
                        ],
                        [
                            'attribute' => 'mobile_number',
                            'label' => 'Phone',
                            'value' => 'profile.mobile_number'
                        ],
                        [
                            'label' => 'Total Orders',
                            'value' => function ($model) {
                                return \restaurant\models\Orders::find()->where(['user_id' => $model->user_id, 'is_deleted' => 0])->count();
                            },
                        ],
                        [
                            'attribute' => 'created_at',
                            'label' => 'Joined On',
                            'value' => function ($model) {
                                return date('M d, Y', $model->created_at);
                            }
                        ],
                        [
                            'class' => \helpers\grid\ActionColumn::className(),
                            'template' => '{view}',
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    return Html::a('<i class="fa fa-eye me-1"></i> View Profile', ['view', 'id' => $model->user_id], ['class' => 'btn btn-sm btn-alt-info']);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
