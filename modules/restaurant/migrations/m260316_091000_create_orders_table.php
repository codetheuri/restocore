<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m260316_091000_create_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'total_amount' => $this->decimal(10, 2)->notNull(),
            'status' => $this->string(32)->notNull()->defaultValue('pending'), // pending, preparing, ready, out_for_delivery, delivered, cancelled
            'payment_status' => $this->string(32)->notNull()->defaultValue('unpaid'), // unpaid, paid, failed, refunded
            'payment_method' => $this->string(32),
            'delivery_address' => $this->text(),
            'phone_number' => $this->string(20),
            'notes' => $this->text(),
            'is_deleted' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('{{%order_items}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'menu_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'unit_price' => $this->decimal(10, 2)->notNull(),
            'subtotal' => $this->decimal(10, 2)->notNull(),
        ]);

        $this->addForeignKey('fk-orders-user_id', '{{%orders}}', 'user_id', '{{%users}}', 'user_id', 'CASCADE');
        $this->addForeignKey('fk-order_items-order_id', '{{%order_items}}', 'order_id', '{{%orders}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-order_items-menu_id', '{{%order_items}}', 'menu_id', '{{%food_menus}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-order_items-menu_id', '{{%order_items}}');
        $this->dropForeignKey('fk-order_items-order_id', '{{%order_items}}');
        $this->dropForeignKey('fk-orders-user_id', '{{%orders}}');
        $this->dropTable('{{%order_items}}');
        $this->dropTable('{{%orders}}');
    }
}
