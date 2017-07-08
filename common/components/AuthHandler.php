<?php

namespace common\components;

use common\clients\ClintInterface;
use common\clients\Facebook;
use common\clients\Twitter;
use common\models\Auth;
use common\models\User;
use Yii;
use yii\authclient\BaseOAuth;
use yii\authclient\ClientInterface;
use yii\base\Exception;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler
{
    /**
     * @var ClientInterface|ClintInterface|BaseOAuth
     */
    private $client;

    /**
     * @var array
     */
    private $supportedClient = [
        Facebook::CODE,
        Twitter::CODE
    ];

    public function __construct(ClientInterface $client)
    {
        if (!in_array($client->getId(), $this->supportedClient)) {
            throw new \Exception('Client does not support');
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
                $user = new User(
                    $this->client->getUserDbAttributes($attributes)
                );
                $user->generateAuthKey();
                $user->save();
            }

            Yii::$app->user->login($user);

        } else {

            if ($authNetwork && $authNetwork->user_id != Yii::$app->user->id) {
                throw new Exception(Yii::t('app', 'Unable to link {client} account. There is another user using it.', ['client' => $this->client->getTitle()]));
            }
        }

        $this->saveAuthClient($authNetwork, $attributes);

        return 123;
//        return Yii::$app->user->getAuthKey();
    }

    /**
     * @param Auth $authNetwork
     * @param $attributes
     * @return Auth
     */
    public function saveAuthClient($authNetwork, array $attributes): Auth
    {
        if (!$authNetwork) {
            $authNetwork = new Auth();
            $authNetwork->id = (string)$attributes['id'];
            $authNetwork->user_id = Yii::$app->user->id;
            $authNetwork->source_id = $this->client->getClientId();
        }

        $authNetwork->token = yii\helpers\Json::encode($this->client->getAccessToken()->getParams());
        $authNetwork->data = yii\helpers\Json::encode($attributes);

        if (!$authNetwork->save()) {
            p($authNetwork->errors);
        }

        return $authNetwork;
    }
}