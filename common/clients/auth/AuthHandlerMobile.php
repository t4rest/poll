<?php

namespace common\clients\auth;

use common\clients\Facebook;
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
    /**
     * @param $client
     * @param $token
     * @param $userId
     * @return array
     * @throws exceptions\RequestException
     */
    public function handle($client, $token, $userId)
    {
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
        }

        $tokenOauth->setParams($token);

        $this->client->setAccessToken($tokenOauth);

        $attributes = $this->client->getUserAttributes();
        $authNetwork = Auth::findOne(['id' => $attributes['id'], 'source_id' => $this->client->getClientId()]);

        if ($authNetwork) {

            if (!empty($userId) && $userId != $authNetwork->user_id) {
                throw exceptions\RequestException::invalidRequest(Yii::t('app', 'Unable to link {client} account. There is another user using it.', ['client' => $this->client->getTitle()]));
            }

            $user = User::findOne($authNetwork->user_id);
        } else {
            $user = $this->createUser($attributes);
        }

        $this->saveAuthClient($user->id, $authNetwork, $attributes);

        return $user->toArray();
    }
}