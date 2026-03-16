<?php

namespace helpers\iam\jwt;

use Yii;
use yii\base\ActionFilter;
use Lcobucci\JWT\Token\Plain;
use Lcobucci\JWT\Validation\Validator;
use iam\models\User;

class Middleware extends ActionFilter
{
    public function beforeAction($action)
    {
        $header = Yii::$app->request->headers->get('Authorization');
        if (!$header || !preg_match('/^Bearer\s+(.+)$/i', $header, $m)) {
            return $this->deny(401, 'Missing or invalid token');
        }

        $config = Yii::$app->jwtConfiguration; 

        try {
            $token = $config->parser()->parse($m[1]);
            if (!($token instanceof Plain)) {
                return $this->deny(401, 'Invalid token type');
            }

            $validator = new Validator();
            if (!$validator->validate($token, ...$config->validationConstraints())) {
                return $this->deny(401, 'Token validation failed');
            }

            $jti = $token->claims()->get('jti');
            if (BlacklistModel::isBlacklisted($jti)) {
                return $this->deny(401, 'Token has been blacklisted');
            }

            $user = User::findIdentity((int) $token->claims()->get('sub'));
            if (!$user) {
                return $this->deny(401, 'User not found or inactive');
            }

            Yii::$app->user->setIdentity($user);
            return true;

        } catch (\Throwable $e) {
            return $this->deny(401, 'Invalid token: ' . $e->getMessage());
        }
    }

    private function deny(int $code, $msg = false)
    {
        $controller = $this->owner ?? Yii::$app->controller;
        if ($controller && method_exists($controller, 'errorResponse')) {
            Yii::$app->response->data = $controller->errorResponse($code, false, $msg);
        } else {
            Yii::$app->response->data = [
                'errorPayload' => [
                    'errors' => ['message' => $msg ?: 'Unauthorized'],
                    'statusCode' => $code
                ]
            ];
        }
        Yii::$app->response->statusCode = $code;
        return false;
    }
}
