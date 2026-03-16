<?php

namespace iam\models\static;

use Yii;
use yii\base\Model;
use iam\models\User;
use iam\models\Profiles;

/**
 * @OA\Schema(
 *     schema="ProfileUpdate",
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="middle_name", type="string", example="Michael", nullable=true),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="mobile_number", type="string", example="+2541700000000"),
 *     @OA\Property(property="physical_address", type="string", example="123 Street, City"),
 *     @OA\Property(property="password", type="string", format="password", example="newpassword123", description="New password if you want to change it"),
 *     @OA\Property(property="confirm_password", type="string", format="password", example="newpassword123")
 * )
 */
class ProfileUpdateForm extends Model
{
    public $first_name;
    public $middle_name;
    public $last_name;
    public $mobile_number;
    public $physical_address;
    public $password;
    public $confirm_password;

    private $_user;

    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        $profile = $user->profile;
        
        $this->first_name = $profile->first_name;
        $this->middle_name = $profile->middle_name;
        $this->last_name = $profile->last_name;
        $this->mobile_number = $profile->mobile_number;
        $this->physical_address = $profile->physical_address;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'mobile_number'], 'required'],
            [['first_name', 'last_name', 'middle_name'], 'string', 'max' => 50],
            [['mobile_number'], 'string', 'max' => 15],
            [['physical_address'], 'string'],
            [['password'], 'string', 'min' => 4],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'when' => function($model) {
                return !empty($model->password);
            }],
        ];
    }

    public function update()
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = $this->_user;
            if (!empty($this->password)) {
                $user->setPassword($this->password);
                if (!$user->save(false)) {
                    throw new \Exception('Failed to update user password.');
                }
            }

            $profile = $user->profile;
            $profile->first_name = $this->first_name;
            $profile->middle_name = $this->middle_name;
            $profile->last_name = $this->last_name;
            $profile->mobile_number = $this->mobile_number;
            $profile->physical_address = $this->physical_address;

            if (!$profile->save(false)) {
                throw new \Exception('Failed to update profile.');
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error('Profile update error: ' . $e->getMessage());
            $this->addError('first_name', 'Update failed: ' . $e->getMessage());
            return false;
        }
    }
}
