<?php

namespace common\clients\auth;

use common\clients\Facebook;
use common\clients\Twitter;
use common\models\Auth;
use common\models\User;
use common\exceptions;
use Yii;
use yii\authclient\OAuthToken;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandlerMobile extends BaseAuthHandler
{

    public function handle()
    {
        $client = Yii::$app->request->post('client');
        $token = Yii::$app->request->post('token', []);

        if (empty($client) || empty($token)) {
            throw exceptions\RequestException::invalidRequest();
        }

        if (!in_array($client, $this->supportedClient)) {
            throw exceptions\RequestException::invalidRequest('Client does not support');
        }


        $this->client = Yii::$app->authClientCollection->getClient($client);

        $tokenOauth = new OAuthToken();
        if ($client == Facebook::CODE) {
            $tokenOauth->tokenParamKey = 'access_token';
        } else {
            $tokenOauth->tokenParamKey = 'oauth_token';
        }

        $tokenOauth->setParams($token);

        $this->client->setAccessToken($tokenOauth);

        $attributes = $this->client->getUserAttributes();
        $authNetwork = Auth::findOne(['id' => $attributes['id'], 'source_id' => $this->client->getClientId()]);

        if ($authNetwork) {
            $user = User::findOne($authNetwork->user_id);
        } else {
            $user = new User($this->client->getUserDbAttributes($attributes));
            $user->generateAuthKey();
            $user->setTime();
            $user->save();
        }

        if (!$this->saveAuthClient($user->id, $authNetwork, $attributes)) {
            throw exceptions\DatabaseException::recordOperationFail();
        }

        return $user->toArray();
    }
}