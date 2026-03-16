<?php

namespace iam\controllers;

use Yii;
use helpers\ApiController;
use iam\models\static\ProfileUpdateForm;

class ProfileController extends ApiController
{
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        if (!$user) {
            return $this->errorResponse(401, false, 'Unauthorized');
        }

        // We want to return user with profile info
        $data = [
            'user_id' => $user->user_id,
            'username' => $user->username,
            'profile' => $user->profile
        ];

        return $this->payloadResponse($data);
    }

    public function actionUpdate()
    {
        $user = Yii::$app->user->identity;
        if (!$user) {
            return $this->errorResponse(401, false, 'Unauthorized');
        }

        $model = new ProfileUpdateForm($user);
        $dataRequest = Yii::$app->request->getBodyParams();

        if ($model->load($dataRequest, '') && $model->update()) {
            return $this->payloadResponse($user->profile, [
                'statusCode' => 200,
                'message' => 'Profile updated successfully',
            ]);
        }

        return $this->errorResponse($model->getErrors());
    }
}
