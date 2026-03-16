<?php

namespace restaurant\controllers;

use Yii;
use helpers\ApiController;
use dashboard\models\MenuCategories;
use dashboard\models\FoodMenus;
use dashboard\models\Banners;
use yii\data\ActiveDataProvider;

class MenuController extends ApiController
{
    /**
     * List food categories
     */
    public function actionCategories()
    {
        $query = MenuCategories::find()->where(['status' => 1, 'is_deleted' => 0])->orderBy(['display_order' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        return $this->payloadResponse($dataProvider, ['oneRecord' => false]);
    }

    /**
     * List all available food items
     */
    public function actionMenu()
    {
        $query = FoodMenus::find()->where(['status' => 1, 'is_deleted' => 0, 'is_available' => 1]);
        
        // Filter by category if provided
        $categoryId = Yii::$app->request->get('category_id');
        if ($categoryId) {
            $query->andWhere(['category_id' => $categoryId]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->get('per-page', 20),
            ],
            'sort' => ['defaultOrder' => ['display_order' => SORT_ASC]]
        ]);

        return $this->payloadResponse($dataProvider, ['oneRecord' => false]);
    }

    /**
     * Get specific details for one item
     */
    public function actionView($id)
    {
        $model = FoodMenus::find()->where(['id' => $id, 'status' => 1, 'is_deleted' => 0])->one();
        if (!$model) {
            return $this->errorResponse(404, false, 'Item not found');
        }
        return $this->payloadResponse($model);
    }

    /**
     * Filter menu items by name or tags
     */
    public function actionSearch()
    {
        $query = Yii::$app->request->get('query');
        if (!$query) {
            return $this->errorResponse(422, false, 'Search query is required');
        }

        $searchQuery = FoodMenus::find()->where(['status' => 1, 'is_deleted' => 0, 'is_available' => 1])
            ->andWhere(['like', 'name', $query]);

        $dataProvider = new ActiveDataProvider([
            'query' => $searchQuery,
            'pagination' => [
                'pageSize' => Yii::$app->request->get('per-page', 20),
            ],
        ]);

        return $this->payloadResponse($dataProvider, ['oneRecord' => false]);
    }

    /**
     * Fetch current discounts or promotional banners
     */
    public function actionOffers()
    {
        $query = Banners::find()->where(['status' => 1, 'is_deleted' => 0]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        return $this->payloadResponse($dataProvider, ['oneRecord' => false]);
    }
}
