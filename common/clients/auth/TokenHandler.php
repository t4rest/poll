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
class TokenHandler
{
    /**
     * @var array
     */
    protected static $supportedClient = [
        Facebook::CODE,
        Twitter::CODE
    ];

    /**
     * @param $client
     * @throws exceptions\RequestException
     */
    public static function validateClient($client)
    {
        if (!in_array($client, self::$supportedClient)) {
            throw exceptions\RequestException::invalidRequest('Client does not support');
        }
    }

    /**
     * @var ClientInterface|Facebook|Twitter
     */
    public $client;

    /**
     * @param int $userId
     * @param Auth|null $authNetwork
     * @param array $attributes
     * @return bool
     * @throws exceptions\RequestException
     */
    public function saveAuthClient(int $userId, Auth $authNetwork = null, array $attributes = []): bool
    {
        if (!$authNetwork) {
            $authNetwork = new Auth();
            $authNetwork->id = (string)$attributes['id'];
            $authNetwork->user_id = $userId;
            $authNetwork->source_id = $this->client->getClientId();
            $authNetwork->data = yii\helpers\Json::encode($attributes);
        }

        $token = $this->client->getAccessToken()->getParams();
        $token['created_at'] = time();

        $authNetwork->token = yii\helpers\Json::encode($this->client->getAccessToken()->getParams());

        if (!$authNetwork->save()) {
            throw exceptions\RequestException::invalidRequestError($authNetwork->getErrors());
        }

        return true;
    }
}