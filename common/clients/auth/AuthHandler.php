<?php

namespace common\clients\auth;

use common\clients\ClientInterface;
use common\clients\Facebook;
use common\clients\Twitter;
use common\models\Auth;
use common\models\User;
use common\exceptions;
use Yii;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler extends BaseAuthHandler
{
    /**
     * AuthHandler constructor.
     * @param ClientInterface|Facebook|Twitter $client
     * @throws \Exception
     */
    public function __construct(ClientInterface $client)
    {
        if (!in_array($client->getId(), $this->supportedClient)) {
            throw exceptions\RequestException::invalidRequest('Client does not support');
        }

        $this->client = $client;
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();
        $authNetwork = Auth::findOne(['id' => $attributes['id'], 'source_id' => $this->client->getClientId()]);

        if (Yii::$app->user->isGuest) {

            if ($authNetwork) {
                $user = User::findOne($authNetwork->user_id);
            } else {
                $user = $this->createUser($attributes);
            }

            Yii::$app->user->login($user);

        } else if ($authNetwork && $authNetwork->user_id != Yii::$app->user->id) {
            Yii::$app->session->set('auth_error', Yii::t('app', 'Unable to link {client} account. There is another user using it.', ['client' => $this->client->getTitle()]));
            return;
        }

        if($this->saveAuthClient(Yii::$app->user->id, $authNetwork, $attributes)) {
            Yii::$app->session->set('auth_token', Yii::$app->user->getIdentity()->getAuthKey());
        } else {
            Yii::$app->session->set('auth_error', Yii::t('app', 'Unable to save {client} account.', ['client' => $this->client->getTitle()]));
        }
    }

}