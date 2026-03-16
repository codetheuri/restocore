<?php

namespace dashboard\controllers;

use Yii;
use iam\models\User;
use dashboard\models\search\CustomerSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;
use restaurant\models\Orders;
use yii\data\ActiveDataProvider;

/**
 * CustomerController implements the actions for viewing customers.
 */
class CustomerController extends DashboardController
{
    public $permissions = [
        'dashboard-customer-list' => 'View Customer List',
        'dashboard-customer-view' => 'View Customer Details',
    ];

    public function getViewPath()
    {
        return Yii::getAlias('@ui/views/cms/customers');
    }

    /**
     * Lists all Customers.
     */
    public function actionIndex()
    {
        Yii::$app->user->can('dashboard-customer-list');
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer details and their order history.
     */
    public function actionView($id)
    {
        Yii::$app->user->can('dashboard-customer-view');
        $model = $this->findModel($id);
        
        $orderDataProvider = new ActiveDataProvider([
            'query' => Orders::find()->where(['user_id' => $id, 'is_deleted' => 0]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('view', [
            'model' => $model,
            'orderDataProvider' => $orderDataProvider,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     */
    protected function findModel($id)
    {
        $class = Yii::$app->getUser()->identityClass;
        if (($model = $class::findIdentity($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested customer does not exist.');
    }
}
