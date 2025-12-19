<?php

use yii\db\Migration;

class m250820_072518_menus_table extends Migration
{
    public function safeUp()
    {
          $this->createTable('{{%banners}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
                'content' => $this->text(),   
            'image_link' => $this->string(255)->notNull(),
        
           
            'status' => $this->integer()->defaultValue(0),
                'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
      $this->createTable('blogs', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
           
            'content' => $this->text()->notNull(),
            'image_link' => $this->string(),
            'author_id' => $this->integer(),
            'published_at' => $this->dateTime(),
           'status' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
                'is_deleted' => $this->integer()->defaultValue(0),
            'updated_at' => $this->integer()->notNull(),
        ]);


         $this->createTable('menu_categories', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'description' => $this->text(),
            'display_order' => $this->integer()->defaultValue(0),
             'status' => $this->integer()->defaultValue(0),
             'is_deleted' => $this->integer()->defaultValue(0),
           'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

      $this->batchInsert('menu_categories', ['name', 'display_order', 'created_at', 'updated_at'], [
            ['Breakfast', 1, time(), time()],
            ['Lunch', 2, time(), time()],
            ['Dinner', 3, time(), time()],
            ['Drinks & Beverages', 4, time(), time()],
            ['Desserts', 5, time(), time()],
            ['Specials', 6, time(), time()],
        ]);
          $this->createTable('food_menus', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'price' => $this->decimal(8, 2)->notNull(),
            'image' => $this->string(),
            
            'category_id' => $this->integer()->notNull(), 
            'is_available' => $this->boolean()->defaultValue(true),
            'display_order' => $this->integer()->defaultValue(0),
             'status' => $this->integer()->defaultValue(0),
             'is_deleted' => $this->integer()->defaultValue(0),
             'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (category_id) REFERENCES {{%menu_categories}} ([[id]])'.
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);


       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%food_menus}}');
        $this->dropTable('{{%menu_categories}}');
        $this->dropTable('{{%blogs}}');
        $this->dropTable('{{%banners}}');
      
    }

   protected function buildFkClause($delete = '', $update = '')
    {
        return implode(' ', ['', $delete, $update]);
    }
}
