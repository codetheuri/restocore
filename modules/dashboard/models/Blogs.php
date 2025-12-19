<?php

namespace dashboard\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "blogs".
 */
class Blogs extends \helpers\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public static function tableName()
    {
        return '{{%blogs}}';
    }

    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            // Image is required only on Create
            [['imageFile'], 'required', 'on' => 'create'],
            
            [['content'], 'string'],
            [['author_id', 'status', 'created_at', 'is_deleted', 'updated_at'], 'integer'],
            [['published_at'], 'safe'],
            [['title', 'image_link', ], 'string', 'max' => 255],
            
            // Image Validation
            [['imageFile'], 'file', 
                'skipOnEmpty' => true, 
                'extensions' => 'png, jpg, jpeg, webp', 
                'maxSize' => 1024 * 1024 * 5 // 5MB
            ],
        ];
    }

    /**
     * Auto-assign Author ID before saving
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->author_id = Yii::$app->user->id;
                // Generate a slug if empty
                // if (empty($this->slug)) {
                //     $this->slug = \yii\helpers\Inflector::slug($this->title);
                // }
            }
            return true;
        }
        return false;
    }

    public function upload()
    {
        if ($this->imageFile) {
            $path = Yii::getAlias('@webroot/uploads/blogs/');
            
            if (!file_exists($path)) {
                FileHelper::createDirectory($path);
            }

            $fileName = 'blog_' . time() . '_' . rand(100, 999) . '.' . $this->imageFile->extension;
            
            if ($this->imageFile->saveAs($path . $fileName)) {
                // Delete old image on update
                if (!$this->isNewRecord && $this->image_link) {
                    $oldFile = Yii::getAlias('@webroot/' . $this->image_link);
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                }

                $this->image_link = 'uploads/blogs/' . $fileName;
                return true;
            }
        }
        return false;
    }
}