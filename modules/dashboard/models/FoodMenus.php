<?php

namespace dashboard\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class FoodMenus extends \helpers\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public static function tableName()
    {
        return '{{%food_menus}}';
    }

    public function rules()
    {
        return [
            [['name', 'price', 'category_id'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['category_id', 'is_available', 'display_order', 'status', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255],
            
           
            [['imageFile'], 'file', 
                'skipOnEmpty' => true, 
                'extensions' => 'png, jpg, jpeg, webp', 
                'maxSize' => 1024 * 1024 * 5 
            ],
            
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuCategories::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }
 
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'image' => 'Image',
            'imageFile' => 'Menu Image',
            'category_id' => 'Category',
            'is_available' => 'Available',
            'display_order' => 'Display Order',
            'status' => 'Status',
        ];
    }
    public function upload()
    {
        if ($this->imageFile) {
            $path = Yii::getAlias('@webroot/uploads/menus/');
            
            if (!file_exists($path)) {
                FileHelper::createDirectory($path);
            }

            
            $fileName = 'menu_' . time() . '_' . rand(100, 999) . '.' . $this->imageFile->extension;
            
            if ($this->imageFile->saveAs($path . $fileName)) {
               
                if (!$this->isNewRecord && $this->image) {
                    $oldFile = Yii::getAlias('@webroot/' . $this->image);
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                }
                
                $this->image = 'uploads/menus/' . $fileName;
                return true;
            }
        }
        return false;
    }

    /**
     * Relation to Category
     */
    public function getCategory()
    {
        return $this->hasOne(MenuCategories::class, ['id' => 'category_id']);
    }
}