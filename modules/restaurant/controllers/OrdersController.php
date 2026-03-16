<?php

namespace restaurant\controllers;

use Yii;
use helpers\ApiController;
use restaurant\models\Orders;
use restaurant\models\OrderCreateForm;
use yii\data\ActiveDataProvider;

class OrdersController extends ApiController
{
    /**
     * Submit a new order
     */
    public function actionCreate()
    {
        $model = new OrderCreateForm();
        $dataRequest = Yii::$app->request->getBodyParams();

        if ($model->load($dataRequest, '') && ($order = $model->save())) {
            return $this->payloadResponse($order, [
                'statusCode' => 201,
                'message' => 'Order placed successfully',
            ]);
        }

        return $this->errorResponse($model->getErrors());
    }

    /**
     * View history of user's past orders
     */
    public function actionHistory()
    {
        $query = Orders::find()->where([
            'user_id' => Yii::$app->user->id,
            'is_deleted' => 0
        ])->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->get('per-page', 10),
            ],
        ]);

        return $this->payloadResponse($dataProvider, ['oneRecord' => false]);
    }

    /**
     * Get details and status of specific order
     */
    public function actionView($id)
    {
        $order = Orders::find()->where([
            'id' => $id,
            'user_id' => Yii::$app->user->id,
            'is_deleted' => 0
        ])->one();

        if (!$order) {
            return $this->errorResponse(404, false, 'Order not found');
        }

        return $this->payloadResponse($order);
    }
}
