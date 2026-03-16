<?php

namespace restaurant\models;

use Yii;
use yii\base\Model;
use dashboard\models\FoodMenus;
use restaurant\models\Orders;
use restaurant\models\OrderItems;

class OrderCreateForm extends Model
{
    public $items; // Array of ['menu_id' => X, 'quantity' => Y]
    public $delivery_address;
    public $phone_number;
    public $payment_method;
    public $notes;

    public function rules()
    {
        return [
            [['items', 'phone_number'], 'required'],
            [['delivery_address', 'notes', 'payment_method'], 'string'],
            ['items', 'validateItems'],
        ];
    }

    public function validateItems($attribute, $params)
    {
        if (!is_array($this->$attribute)) {
            $this->addError($attribute, 'Items must be an array.');
            return;
        }

        foreach ($this->$attribute as $item) {
            if (!isset($item['menu_id']) || !isset($item['quantity'])) {
                $this->addError($attribute, 'Each item must have menu_id and quantity.');
                return;
            }
            $menu = FoodMenus::findOne($item['menu_id']);
            if (!$menu || $menu->is_deleted || $menu->status != 1 || !$menu->is_available) {
                $this->addError($attribute, "Menu item with ID {$item['menu_id']} is not available.");
            }
        }
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $order = new Orders();
            $order->user_id = Yii::$app->user->id;
            $order->delivery_address = $this->delivery_address;
            $order->phone_number = $this->phone_number;
            $order->payment_method = $this->payment_method;
            $order->notes = $this->notes;
            $order->total_amount = 0; // Will calculate
            
            if (!$order->save()) {
                throw new \Exception('Failed to save order.');
            }

            $total = 0;
            foreach ($this->items as $itemData) {
                $menu = FoodMenus::findOne($itemData['menu_id']);
                $quantity = $itemData['quantity'];
                
                $orderItem = new OrderItems();
                $orderItem->order_id = $order->id;
                $orderItem->menu_id = $menu->id;
                $orderItem->quantity = $quantity;
                $orderItem->unit_price = $menu->price;
                $orderItem->subtotal = $menu->price * $quantity;
                
                if (!$orderItem->save()) {
                    throw new \Exception('Failed to save order item.');
                }
                
                $total += $orderItem->subtotal;
            }

            $order->total_amount = $total;
            if (!$order->save()) {
                throw new \Exception('Failed to update order total.');
            }

            $transaction->commit();
            return $order;
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error('Order placement error: ' . $e->getMessage());
            $this->addError('items', 'Failed to place order: ' . $e->getMessage());
            return false;
        }
    }
}
