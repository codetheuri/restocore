<?php

namespace restaurant\models;

use Yii;
use helpers\ActiveRecord;
use dashboard\models\FoodMenus;
use restaurant\models\Orders;

/**
 * This is the model class for table "order_items".
 */
class OrderItems extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%order_items}}';
    }

    public function rules()
    {
        return [
            [['order_id', 'menu_id', 'quantity', 'unit_price', 'subtotal'], 'required'],
            [['order_id', 'menu_id', 'quantity'], 'integer'],
            [['unit_price', 'subtotal'], 'number'],
        ];
    }

    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['id' => 'order_id']);
    }

    public function getMenu()
    {
        return $this->hasOne(FoodMenus::class, ['id' => 'menu_id']);
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['menu_details'] = function($model) {
            return $model->menu;
        };
        return $fields;
    }
}
