<?php

namespace main\controllers;

use Yii;
use yii\web\Response;
use dashboard\models\Banners;
use dashboard\models\Blogs;
use dashboard\models\MenuCategories;
use dashboard\models\ContactForm;
use yii\web\NotFoundHttpException;
class SiteController extends \helpers\WebController
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
  
    $banners = Banners::find()
        ->where(['status' => 1, 'is_deleted' => 0])
        ->orderBy(['id' => SORT_DESC]) 
        ->all();

     $latestBlogs = Blogs::find()
        ->where(['status' => 1, 'is_deleted' => 0])
        ->orderBy(['published_at' => SORT_DESC])
        ->limit(2) 
        ->all();  
        
     $foodCategories = MenuCategories::find()
        ->where(['status' => 1, 'is_deleted' => 0])
        ->orderBy(['display_order' => SORT_ASC]) 
        ->limit(3) 
        ->all();   

    return $this->render('index', [
        'banners' => $banners,
        'latestBlogs' => $latestBlogs,
        'foodCategories' => $foodCategories
    ]);
}

  public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $mailer = Yii::createObject([
                'class' => 'cynefin\hooks\Mail',
                'viewPath' => '@cynefin/templates/',
            ]);
            if ($mailer->sendContactEmail(
                $model->name,
                $model->email,
                $model->subject,
                $model->message
            )) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us! We will get back to you soon.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message. Please try again.');
            }
            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }
public function actionAbout()
{
    return $this->render('about', [
     
    ]);
}

    
   public function actionMenu()
{
    
    $categories = MenuCategories::find()
        ->where(['status' => 1, 'is_deleted' => 0])
        ->with(['foodMenuses' => function ($query) {
            $query->where(['status' => 1, 'is_available' => 1, 'is_deleted' => 0])
                  ->orderBy(['price' => SORT_ASC]); // Optional: Sort food by price
        }])
        ->orderBy(['display_order' => SORT_ASC])
        ->all();

    
    $activeCategories = array_filter($categories, function($cat) {
        return !empty($cat->foodMenuses);
    });

    return $this->render('menu', [
        'categories' => $activeCategories
    ]);
}
    public function actionBlog()
    {
       
        $blogs = Blogs::find()
            ->where(['status' => 1, 'is_deleted' => 0])
            ->orderBy(['published_at' => SORT_DESC])
            ->all();

        return $this->render('blog', [
            'blogs' => $blogs
        ]);
    }


    public function actionBlogDetails($id)
    {
        
        $blog = Blogs::find()
            ->where(['id' => $id, 'status' => 1, 'is_deleted' => 0])
            ->one();

        if ($blog === null) {
            throw new NotFoundHttpException('The requested blog post does not exist.');
        }

        return $this->render('blog-details', [
            'blog' => $blog
        ]);
    }
 
    public function actionDocs($mod = 'dashboard')
    {
        //$this->viewPath = '@swagger';
        return $this->render('docs', [
            'mod' => $mod
        ]);
    }
  
    // public function actionAbout()
    // {
    //     return [
    //         'data' => [
    //             'id' => $_SERVER['APP_CODE'],
    //             'name' => $_SERVER['APP_NAME'],
    //             'enviroment' => $_SERVER['ENVIRONMENT'],
    //             'version' => $_SERVER['APP_VERSION'],
    //         ]
    //     ];
    // }

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
}
