<?php

namespace dashboard\controllers;

use Yii;
use dashboard\models\FoodMenus;
use dashboard\models\search\FoodMenuSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
/**
 * FoodMenuController implements the CRUD actions for FoodMenus model.
 */
class FoodMenuController extends DashboardController
{
    public $permissions = [
        'dashboard-food-menu-list'=>'View FoodMenus List',
        'dashboard-food-menu-create'=>'Add FoodMenus',
        'dashboard-food-menu-update'=>'Edit FoodMenus',
        'dashboard-food-menu-delete'=>'Delete FoodMenus',
        'dashboard-food-menu-restore'=>'Restore FoodMenus',
        ];
        public function getViewPath()
    {
     return Yii::getAlias('@ui/views/cms/food-menus');
    }
    public function actionIndex()
    {
        Yii::$app->user->can('dashboard-food-menu-list');
        $searchModel = new FoodMenuSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('dashboard-food-menu-create');
        $model = new FoodMenus();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                
                if ($model->validate()) {
                    if ($model->imageFile) {
                        $model->upload();
                    }
                    if ($model->save(false)) {
                        Yii::$app->session->setFlash('success', 'Menu item created.');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }
   if ($this->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionUpdate($id)
    {
        Yii::$app->user->can('dashboard-food-menu-update');
        $model = $this->findModel($id);
       if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                
                if ($model->validate()) {
                    if ($model->imageFile) {
                        $model->upload();
                    }
                    if ($model->save(false)) {
                        Yii::$app->session->setFlash('success', 'Menu item updated.');
                        return $this->redirect(['index']);
                    }
                }
            }
        }
     if ($this->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionStatus($id)
    {
        $model = $this->findModel($id);
        $model->status = ($model->status == 1) ? 0 : 1;
        $model->save(false);
        return $this->redirect(['index']);
    }
    public function actionTrash($id)
    {
        $model = $this->findModel($id);
        if ($model->is_deleted) {
            Yii::$app->user->can('dashboard-food-menu-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'FoodMenus has been restored');
        } else {
            Yii::$app->user->can('dashboard-food-menu-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'FoodMenus has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = FoodMenus::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
