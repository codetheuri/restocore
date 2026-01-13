<?php
namespace dashboard\models;

use Yii;
use yii\base\Model;

class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $message;

    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'message'], 'required'],
            ['email', 'email'],
            [['name', 'subject'], 'string', 'max' => 255],
            ['message', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Your Name',
            'email' => 'Your Email',
            'subject' => 'Subject',
            'message' => 'Message',
        ];
    }
}