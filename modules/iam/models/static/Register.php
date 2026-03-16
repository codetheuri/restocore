<?php

namespace iam\models\static;

use Yii;
use yii\base\Model;
use iam\models\User;
use iam\models\Profiles;

/**
 * @OA\Schema(
 *     schema="Register",
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="middle_name", type="string", example="Michael", nullable=true),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="email_address", type="string", format="email", example="john.doe@example.com"),
 *     @OA\Property(property="mobile_number", type="string", example="+2541700000000"),
 *     @OA\Property(property="physical_address", type="string", example="123 Street, City", nullable=true),
 *     @OA\Property(property="username", type="string", example="johndoe"),
 *     @OA\Property(property="password", type="string", format="password", example="@dmiN1234$"),
 *     @OA\Property(property="confirm_password", type="string", format="password", example="@dmiN1234$"),
 * )
 */
class Register extends Model
{
    public $first_name;
    public $middle_name;
    public $last_name;
    public $email_address;
    public $mobile_number;
    public $physical_address;
    public $username;
    public $password;
    public $confirm_password;

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email_address', 'mobile_number', 'username', 'password', 'confirm_password'], 'required'],
            [['first_name', 'last_name', 'middle_name'], 'string', 'max' => 50],
            [['physical_address'], 'string'],
            ['email_address', 'email'],
            ['email_address', 'unique', 'targetClass' => Profiles::class, 'message' => 'This email is already registered.'],
            ['username', 'trim'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'This username is already taken.'],
            ['password', 'string', 'min' => 4],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new User();
            $user->username = $this->username;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->status = User::STATUS_ACTIVE;

            // Generate user_id using the incrementer logic
            $currentYear = date('Y');
            $incrementer = Yii::$app->db->createCommand(
                'SELECT * FROM {{%incrementer}} WHERE type = :type AND year = :year FOR UPDATE',
                ['type' => 'user_id', 'year' => $currentYear]
            )->queryOne();

            if (!$incrementer) {
                Yii::$app->db->createCommand()->insert('{{%incrementer}}', [
                    'year' => $currentYear,
                    'value' => 1,
                    'type' => 'user_id',
                    'created_at' => time(),
                    'updated_at' => time(),
                ])->execute();
                $user->user_id = $currentYear . '0001';
            } else {
                $nextValue = $incrementer['value'] + 1;
                Yii::$app->db->createCommand()->update('{{%incrementer}}', [
                    'value' => $nextValue,
                    'updated_at' => time(),
                ], ['id' => $incrementer['id']])->execute();
                $user->user_id = $currentYear . str_pad($nextValue, 4, '0', STR_PAD_LEFT);
            }

            if (!$user->save(false)) {
                throw new \Exception('Failed to save user.');
            }

            $profile = new Profiles();
            $profile->user_id = $user->user_id;
            $profile->first_name = $this->first_name;
            $profile->middle_name = $this->middle_name ?: null;
            $profile->last_name = $this->last_name;
            $profile->email_address = $this->email_address;
            $profile->mobile_number = $this->mobile_number;
            $profile->physical_address = $this->physical_address;

            if (!$profile->save(false)) {
                throw new \Exception('Failed to save profile.');
            }

            // Assign 'customer' role
            $auth = Yii::$app->authManager;
            $customerRole = $auth->getRole('customer');
            if (!$customerRole) {
                $customerRole = $auth->createRole('customer');
                $auth->add($customerRole);
            }
            $auth->assign($customerRole, $user->user_id);

            $transaction->commit();
            return $user;
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error('Registration error: ' . $e->getMessage());
            $this->addError('username', 'Registration failed: ' . $e->getMessage());
            return null;
        }
    }
}
