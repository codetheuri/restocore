<?php

namespace dashboard\controllers;

use Yii;
use dashboard\models\MenuCategories;
use dashboard\models\search\MenuCategoriesSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * MenuCategoryController implements the CRUD actions for MenuCategories model.
 */
class MenuCategoryController extends DashboardController
{
    public $permissions = [
        'dashboard-menu-category-list'=>'View MenuCategories List',
        'dashboard-menu-category-create'=>'Add MenuCategories',
        'dashboard-menu-category-update'=>'Edit MenuCategories',
        'dashboard-menu-category-delete'=>'Delete MenuCategories',
        'dashboard-menu-category-restore'=>'Restore MenuCategories',
        ];

        public function getViewPath()
    {
     return Yii::getAlias('@ui/views/cms/menu-categories');
    }
    public function actionIndex()
    {
        Yii::$app->user->can('dashboard-menu-category-list');
        $searchModel = new MenuCategoriesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('dashboard-menu-category-create');
        $model = new MenuCategories();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'MenuCategories created successfully');
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
        Yii::$app->user->can('dashboard-menu-category-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'MenuCategories updated successfully');
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
    public function actionTrash($id)
    {
        $model = $this->findModel($id);
        if ($model->is_deleted) {
            Yii::$app->user->can('dashboard-menu-category-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'MenuCategories has been restored');
        } else {
            Yii::$app->user->can('dashboard-menu-category-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'MenuCategories has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = MenuCategories::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionStatus($id)
{
    $model = $this->findModel($id);
   
    $model->status = ($model->status == 1) ? 0 : 1;
    
    if ($model->save(false)) {
        Yii::$app->session->setFlash('success', 'Category status updated.');
    }
    return $this->redirect(['index']);
}
}
