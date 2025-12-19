<?php

namespace dashboard\models;

use Yii;

/**
 * This is the model class for table "menu_categories".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $display_order
 * @property int|null $status
 * @property int|null $is_deleted
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property FoodMenus[] $foodMenuses
 */
class MenuCategories extends \helpers\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['display_order', 'status', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'display_order' => 'Display Order',
            'status' => 'Status',
            'is_deleted' => 'Is Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[FoodMenuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFoodMenuses()
    {
        return $this->hasMany(FoodMenus::class, ['category_id' => 'id']);
    }
}
