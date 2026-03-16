<?php

namespace iam\controllers;

use Yii;
use helpers\ApiController;
use iam\models\static\Login;
use iam\models\static\Register;
use helpers\iam\jwt\RefreshTokenModel;
use helpers\iam\jwt\BlacklistModel;
use iam\models\User;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="Available endpoints for user authentication"
 * )
 */
class AuthController extends ApiController
{
    public function actionRegister()
    {
        $model = new Register();
        $dataRequest = Yii::$app->request->getBodyParams();
        // Register model in restocore expects ['username', 'password', 'confirm_password']
        // Dukapal expects first_name, last_name, email_address, mobile_number, username, password, confirm_password
        // I will adapt the restocore Register model or just load what we have.
        // For now, let's load attributes directly.
        if ($model->load($dataRequest, '') && ($user = $model->save())) {
            return $this->payloadResponse($user, [
                'statusCode' => 201,
                'message'    => 'Registration successful.',
            ]);
        }

        return $this->errorResponse($model->getErrors());
    }

    public function actionLogin()
    {
        $model = new Login();
        $dataRequest = Yii::$app->request->getBodyParams();
        
        if ($model->load($dataRequest, '') && $model->login()) {
            $user = Yii::$app->user->identity;
            return $this->payloadResponse($this->generateTokens($user->user_id), [
                'statusCode' => 200,
                'message' => 'Access granted',
            ]);
        }
        return $this->errorResponse($model->getErrors());
    }

    public function actionMe()
    {
        $user = Yii::$app->user->identity;
        if (!$user) {
            return $this->errorResponse(401, false, 'Unauthorized');
        }
        return $this->payloadResponse($user, [
            'statusCode' => 200,
        ]);
    }

    public function actionRefresh()
    {
        $refreshToken = Yii::$app->request->cookies->getValue('refresh_token');
        if (!$refreshToken) {
            return $this->errorResponse(401, false, 'No refresh token');
        }
        $rt = RefreshTokenModel::findValid($refreshToken);
        if (!$rt) {
            Yii::$app->response->cookies->remove('refresh_token');
            return $this->errorResponse(401, false, 'Invalid refresh token');
        }
        $rt->is_revoked = 1;
        $rt->save(false);
        
        return $this->payloadResponse($this->generateTokens($rt->user_id), [
            'statusCode' => 200,
        ]);
    }

    public function actionLogout()
    {
        $user = Yii::$app->user->identity;
        if (!$user) {
            return $this->alertifyResponse([
                'statusCode' => 200,
                'message'    => 'You are already logged out.',
                'theme'      => 'info',
                'type'       => 'toast'
            ]);
        }

        $authHeader = Yii::$app->request->headers->get('Authorization');
        if ($authHeader && preg_match('/^Bearer\s+(.+)$/i', $authHeader, $m)) {
            try {
                $token = Yii::$app->jwtConfiguration->parser()->parse($m[1]);
                $jti = $token->claims()->get('jti');
                $exp = $token->claims()->get('exp');
                BlacklistModel::add($jti, $exp->getTimestamp());
            } catch (\Throwable $e) {}
        }

        $this->logoutFromCurrentDevice();
        Yii::$app->user->logout(false);
        Yii::$app->response->cookies->remove('refresh_token');

        return $this->alertifyResponse([
            'statusCode' => 200,
            'message'    => 'Logged out successfully.',
            'theme'      => 'success',
            'type'       => 'toast'
        ]);
    }

    private function logoutFromCurrentDevice()
    {
        $refreshToken = Yii::$app->request->cookies->getValue('refresh_token');
        if ($refreshToken) {
            $rt = RefreshTokenModel::findValid($refreshToken);
            if ($rt) {
                $rt->is_revoked = 1;
                $rt->save(false);
                BlacklistModel::add($rt->jti, $rt->expires_at);
            }
        }
    }

    private function generateTokens($userId)
    {
        $jwt = Yii::$app->jwtConfiguration;
        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $jti = bin2hex(random_bytes(16));

        $accessTtl = Yii::$app->params['jwtAccessTokenTtl'] ?? 3600;
        $accessExpires = $now->modify('+' . $accessTtl . ' seconds');

        $user = User::findIdentity($userId);

        $token = $jwt->builder()
            ->relatedTo((string) $userId)
            ->identifiedBy($jti)
            ->issuedAt($now)
            ->expiresAt($accessExpires)
            ->issuedBy(Yii::$app->request->getHostInfo())
            ->permittedFor(Yii::$app->request->getHostInfo())
            ->withClaim('name', $user->username)
            ->getToken($jwt->signer(), $jwt->signingKey());

        $accessToken = $token->toString();

        $refreshTtl = Yii::$app->params['jwtRefreshTokenTtl'] ?? 7776000;
        $refreshExpires = time() + $refreshTtl;
        $refreshRecord = RefreshTokenModel::create($userId, $jti, $refreshExpires);

        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name'     => 'refresh_token',
            'value'    => $refreshRecord->token,
            'expire'   => $refreshExpires,
            'httpOnly' => true,
            'secure'   => !YII_ENV_DEV,
            'sameSite' => \yii\web\Cookie::SAME_SITE_LAX,
            'path'     => '/',
        ]));

        return [
            'access_token' => $accessToken,
            'expires_in'   => $accessTtl,
            'token_type'   => 'Bearer',
        ];
    }
}
