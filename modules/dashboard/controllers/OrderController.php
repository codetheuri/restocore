<?php

namespace dashboard\controllers;

use Yii;
use restaurant\models\Orders;
use dashboard\models\search\OrderSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * OrderController implements the CRUD actions for Orders model.
 */
class OrderController extends DashboardController
{
    public $permissions = [
        'dashboard-order-list' => 'View Orders List',
        'dashboard-order-view' => 'View Order Details',
        'dashboard-order-update' => 'Manage Order Status',
        'dashboard-order-delete' => 'Delete Order',
    ];

    public function getViewPath()
    {
        return Yii::getAlias('@ui/views/cms/orders');
    }

    /**
     * Lists all Orders models.
     */
    public function actionIndex()
    {
        Yii::$app->user->can('dashboard-order-list');
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     */
    public function actionView($id)
    {
        Yii::$app->user->can('dashboard-order-view');
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates the status of an existing Orders model.
     */
    public function actionUpdateStatus($id, $status)
    {
        Yii::$app->user->can('dashboard-order-update');
        $model = $this->findModel($id);
        $model->status = $status;
        
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', "Order status updated to $status.");
        } else {
            Yii::$app->session->setFlash('error', "Failed to update order status.");
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Updates the payment status of an existing Orders model.
     */
    public function actionUpdatePayment($id, $status)
    {
        Yii::$app->user->can('dashboard-order-update');
        $model = $this->findModel($id);
        $model->payment_status = $status;
        
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', "Payment status updated to $status.");
        } else {
            Yii::$app->session->setFlash('error', "Failed to update payment status.");
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Deletes an existing Orders model.
     */
    public function actionDelete($id)
    {
        Yii::$app->user->can('dashboard-order-delete');
        $model = $this->findModel($id);
        $model->is_deleted = 1;
        $model->save(false);

        Yii::$app->session->setFlash('success', 'Order has been deleted.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested order does not exist.');
    }
}
