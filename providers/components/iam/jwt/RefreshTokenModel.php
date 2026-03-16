<?php

namespace helpers\iam\jwt;

use Yii;
use helpers\ActiveRecord;

class RefreshTokenModel extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%jwt_refresh_tokens}}';
    }
    
    public static function findValid($token)
    {
        return self::find()
            ->where(['token' => $token, 'is_revoked' => 0])
            ->andWhere(['>', 'expires_at', time()])
            ->one();
    }

    public static function create($userId, $jti, $expires)
    {
        $token = new self();
        $token->user_id = $userId;
        $token->token = Yii::$app->security->generateRandomString(128);
        $token->jti = $jti;
        $token->expires_at = $expires;
        $token->ip_address = Yii::$app->request->userIP;
        $token->user_agent = Yii::$app->request->userAgent;
        $token->save();
        return $token;
    }
}
