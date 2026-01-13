<?php

namespace dashboard\models;

use Yii;
use yii\helpers\FileHelper;

class Banners extends \helpers\ActiveRecord
{
    /**
     * @var \yii\web\UploadedFile
     */
    public $imageFile;

    public static function tableName()
    {
        return '{{%banners}}'; 
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            // Require imageFile only on 'create' scenario. 
            // On 'update', it's optional (if empty, we keep the old image).
            [['imageFile'], 'required', 'on' => 'create'], 
            
            [['content'], 'string'],
            [['status', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['title', 'image_link'], 'string', 'max' => 255],
            
            [['imageFile'], 'file', 
                'skipOnEmpty' => true, 
                'extensions' => 'png, jpg, jpeg, webp', 
                'maxSize' => 1024 * 1024 * 5 // 5MB limit
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'image_link' => 'Image Link',
            'imageFile' => 'Banner Image',
            'status' => 'Status',
        ];
    }

    public function upload()
    {
        if ($this->imageFile) {
            $path = Yii::getAlias('@webroot/uploads/banners/');
            
            if (!file_exists($path)) {
                FileHelper::createDirectory($path);
            }

            // Generate unique name
            $fileName = 'banner_' . time() . '_' . rand(100, 999) . '.' . $this->imageFile->extension;
            
            if ($this->imageFile->saveAs($path . $fileName)) {
                // Delete old image if it exists (Optional cleanup)
                if (!$this->isNewRecord && $this->image_link) {
                    $oldFile = Yii::getAlias('@webroot/' . $this->image_link);
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                $this->image_link = 'uploads/banners/' . $fileName;
                return true;
            }
        }
        return false;
    }
}