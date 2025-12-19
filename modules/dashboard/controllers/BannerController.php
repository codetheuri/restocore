<?php

namespace dashboard\controllers;

use Yii;
use dashboard\models\Banners;
use dashboard\models\search\BannersSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class BannerController extends DashboardController
{
    // ... permissions ... (keep your existing permissions array)

    public function getViewPath()
    {
        return Yii::getAlias('@ui/views/cms/banners');
    }

    public function actionIndex()
    {
        Yii::$app->user->can('dashboard-banner-list');
        $searchModel = new BannersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        Yii::$app->user->can('dashboard-banner-create');
        $model = new Banners(['scenario' => 'create']); // Set scenario

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                
                // 1. Get File Instance
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                // 2. Validate (Rules check imageFile requirement)
                if ($model->validate()) {
                    // 3. Upload & Save
                    if ($model->imageFile) {
                        $model->upload(); // Sets $model->image_link
                    }
                    
                    if ($model->save(false)) { // Skip validation since we already validated
                        Yii::$app->session->setFlash('success', 'Banner created successfully');
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
        Yii::$app->user->can('dashboard-banner-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                if ($model->validate()) {
                    // Only call upload if a NEW file was selected
                    if ($model->imageFile) {
                        $model->upload(); 
                    }
                    
                    if ($model->save(false)) {
                        Yii::$app->session->setFlash('success', 'Banner updated successfully');
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
             // restore logic
             $model->is_deleted = 0;
             $model->save(false);
        } else {
             // delete logic
             $model->is_deleted = 1;
             $model->save(false);
        }
        return $this->redirect(['index']);
    }
public function actionStatus($id)
    {
        // Optional: Check permission
        // Yii::$app->user->can('dashboard-banner-update');

        $model = $this->findModel($id);

        // Toggle logic: If 1 make 0, if 0 make 1
        $model->status = ($model->status == 1) ? 0 : 1;
        
        if ($model->save(false)) { // false skips validation to make it fast
            $statusMsg = $model->status == 1 ? 'published' : 'moved to drafts';
            Yii::$app->session->setFlash('success', "Banner has been $statusMsg.");
        } else {
            Yii::$app->session->setFlash('error', 'Could not update status.');
        }

        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Banners::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}