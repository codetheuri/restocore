<?php

namespace restaurant\models;

use Yii;
use helpers\ActiveRecord;
use iam\models\User;
use dashboard\models\FoodMenus;
use restaurant\models\OrderItems;

/**
 * This is the model class for table "orders".
 */
class Orders extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%orders}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'total_amount'], 'required'],
            [['user_id', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['total_amount'], 'number'],
            [['delivery_address', 'notes'], 'string'],
            [['status', 'payment_status', 'payment_method'], 'string', 'max' => 32],
            [['phone_number'], 'string', 'max' => 20],
        ];
    }

    public function getItems()
    {
        return $this->hasMany(OrderItems::class, ['order_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'user_id']);
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['items'] = function($model) {
            return $model->items;
        };
        return $fields;
    }
}
