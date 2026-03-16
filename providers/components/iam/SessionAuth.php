<?php

namespace helpers\iam;

use yii\filters\auth\AuthMethod;

/**
 * SessionAuth is an authentication method that uses the existing session 
 * (standard Yii user identification) for authentication.
 */
class SessionAuth extends AuthMethod
{
    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        // If the user is already authenticated via session, return the identity
        $identity = $user->getIdentity();
        if ($identity !== null) {
            return $identity;
        }

        return null;
    }
}
