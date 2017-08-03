<?php

namespace common\clients\auth;

use common\clients\ClientInterface;
use common\clients\Facebook;
use common\clients\Twitter;
use common\models\Auth;
use Yii;


class BaseAuthHandler
{
    /**
     * @var array
     */
    protected $supportedClient = [
        Facebook::CODE,
        Twitter::CODE
    ];

    /**
     * @var ClientInterface|Facebook|Twitter
     */
    public $client;

    /**
     * @param $userId
     * @param $authNetwork
     * @param array $attributes
     * @return bool
     */
    public function saveAuthClient($userId, $authNetwork, array $attributes): bool
    {
        if (!$authNetwork) {
            $authNetwork = new Auth();
            $authNetwork->id = (string)$attributes['id'];
            $authNetwork->user_id = $userId;
            $authNetwork->source_id = $this->client->getClientId();
        }

        $authNetwork->token = yii\helpers\Json::encode($this->client->getAccessToken()->getParams());
        $authNetwork->data = yii\helpers\Json::encode($attributes);

        if(! $authNetwork->save()) {
            p($authNetwork->errors);
        }

        return $authNetwork->save();
    }
}