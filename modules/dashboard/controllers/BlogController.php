<?php

namespace dashboard\controllers;

use Yii;
use dashboard\models\Blogs;
use dashboard\models\search\BlogsSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * BlogController implements the CRUD actions for Blogs model.
 */
class BlogController extends DashboardController
{
    public $permissions = [
        'dashboard-blog-list'=>'View Blogs List',
        'dashboard-blog-create'=>'Add Blogs',
        'dashboard-blog-update'=>'Edit Blogs',
        'dashboard-blog-delete'=>'Delete Blogs',
        'dashboard-blog-restore'=>'Restore Blogs',
        ];

        public function getViewPath()
    {
     return Yii::getAlias('@ui/views/cms/blog');
    }
    public function actionIndex()
    {
        Yii::$app->user->can('dashboard-blog-list');
        $searchModel = new BlogsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('dashboard-blog-create');
      $model = new Blogs(['scenario' => 'create']);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                
                if ($model->validate()) {
                    if ($model->imageFile) {
                        $model->upload();
                    }
                    
                    if ($model->save(false)) {
                        Yii::$app->session->setFlash('success', 'Blog post created successfully');
                        return $this->redirect(['index']);
                    }else {
                    // --- DEBUGGING: SHOW ME THE ERROR ---
                    // If validation fails, this message will show you WHY
                    Yii::$app->session->setFlash('error', 'Validation Failed: ' . json_encode($model->errors));
                }
                }
            }
        } else {
            $model->loadDefaultValues();
            $model->published_at = date('Y-m-d H:i'); // Default to now
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
        Yii::$app->user->can('dashboard-blog-update');
       $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                
                if ($model->validate()) {
                    if ($model->imageFile) {
                        $model->upload();
                    }
                    
                    if ($model->save(false)) {
                        Yii::$app->session->setFlash('success', 'Blog updated successfully');
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
            Yii::$app->user->can('dashboard-blog-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'Blogs has been restored');
        } else {
            Yii::$app->user->can('dashboard-blog-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'Blogs has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Blogs::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionStatus($id)
    {
        $model = $this->findModel($id);
        // Toggle 1 <-> 0
        $model->status = ($model->status == 1) ? 0 : 1;
        
        if ($model->save(false)) {
            $msg = $model->status == 1 ? 'published' : 'moved to drafts';
            Yii::$app->session->setFlash('success', "Blog post has been $msg.");
        }
        return $this->redirect(['index']);
    }
}
