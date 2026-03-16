<?php

namespace dashboard\controllers;

use Yii;
use yii\web\Response;

use mail\models\static\contactForm;
use dashboard\models\Banners;
use dashboard\models\Blogs;
use dashboard\models\FoodMenus;
use restaurant\models\Orders;
class HomeController extends \helpers\DashboardController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(),  [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['index'],
                'formats' => [
                    'application/json' => Response::FORMAT_HTML,
                ],
            ],
        ]);
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'errors'
            ],
        ];
    }
   public function actionIndex()
    {
        // 1. Fetch Key Metrics
        $totalMenu = FoodMenus::find()->where(['is_deleted' => 0])->count();
        $activeMenu = FoodMenus::find()->where(['status' => 1, 'is_available' => 1, 'is_deleted' => 0])->count();
        
        $totalBlogs = Blogs::find()->where(['is_deleted' => 0])->count();
        $publishedBlogs = Blogs::find()->where(['status' => 1, 'is_deleted' => 0])->count();
        
        $activeBanners = Banners::find()->where(['status' => 1, 'is_deleted' => 0])->count();
        
        $pendingOrders = Orders::find()->where(['status' => 'pending', 'is_deleted' => 0])->count();
        $totalOrders = Orders::find()->where(['is_deleted' => 0])->count();
        
        $totalCustomers = Yii::$app->authManager->getUserIdsByRole('customer') ;
        $activeCustomers = count($totalCustomers);
        
      
        return $this->render('index', [
            'totalMenu' => $totalMenu,
            'activeMenu' => $activeMenu,
            'totalBlogs' => $totalBlogs,
            'publishedBlogs' => $publishedBlogs,
            'activeBanners' => $activeBanners,
            'pendingOrders' => $pendingOrders,
            'totalOrders' => $totalOrders,
            'totalCustomers' => $activeCustomers,
        ]);
    }
    public function actionDocs($mod = 'dashboard')
    {
        //$this->viewPath = '@swagger';
        return $this->render('docs', [
            'mod' => $mod
        ]);
    }
    public function actionAbout()
    {
        return [
            'data' => [
                'id' => $_SERVER['APP_CODE'],
                'name' => $_SERVER['APP_NAME'],
                'enviroment' => $_SERVER['ENVIRONMENT'],
                'version' => $_SERVER['APP_VERSION'],
            ]
        ];
    }

    public function actionJsonDocs($mod = 'dashboard')
    {
        $roothPath = Yii::getAlias('@webroot/');
        $openapi = \OpenApi\Generator::scan(
            [
                $roothPath . 'modules/' . $mod,
                $roothPath . 'config',
            ]
        );
        Yii::$app->response->headers->set('Access-Control-Allow-Origin', ['*']);
        Yii::$app->response->headers->set('Content-Type', 'application/json');
        $file =  $roothPath . 'modules/dashboard/docs/' . $mod . '-openapi-json-resource.json';
        if (file_exists($file)) {
            unlink($file);
            file_put_contents($file, $openapi->toJson());
        } else {
            file_put_contents($file, $openapi->toJson());
        }
        Yii::$app->response->sendFile($file, false, ['mimeType' => 'json', 'inline' => true]);
        return true;
    }
     /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('success', 'check your email');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
}
}
