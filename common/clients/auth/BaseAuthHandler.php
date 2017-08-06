<?php

namespace common\clients\auth;

use common\clients\ClientInterface;
use common\clients\Facebook;
use common\clients\Twitter;
use common\models\Auth;
use Yii;
use common\models\User;
use common\exceptions;

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
     * @param int $userId
     * @param Auth|null $authNetwork
     * @param array $attributes
     * @return bool
     * @throws exceptions\RequestException
     */
    public function saveAuthClient(int $userId, Auth $authNetwork = null, array $attributes): bool
    {
        if (!$authNetwork) {
            $authNetwork = new Auth();
            $authNetwork->id = (string)$attributes['id'];
            $authNetwork->user_id = $userId;
            $authNetwork->source_id = $this->client->getClientId();
        }

        $authNetwork->token = yii\helpers\Json::encode($this->client->getAccessToken()->getParams());
        $authNetwork->data = yii\helpers\Json::encode($attributes);

        if (!$authNetwork->save()) {
            throw exceptions\RequestException::invalidRequestError($authNetwork->getErrors());
        }

        return true;
    }


    /**
     * @param array $attributes
     * @return User
     * @throws exceptions\RequestException
     */
    public function createUser(array $attributes): User
    {
        $data = $this->client->getUserDbAttributes($attributes);
        $data['username'] = $this->slug($data['username']);

        $unique = User::find()->where(['username' => $data['username']])->one();
        if ($unique) {
            $data['username'] .= '_' . time();
        }

        $user = new User($data);
        $user->generateAuthKey();
        $user->setTime();
        if ($user->save()) {
            throw exceptions\RequestException::invalidRequestError($user->getErrors());
        }

        return $user;
    }

    /**
     * @param $string
     * @return string
     */
    public function slug(string $string): string
    {
        return strtolower(trim(preg_replace('~[^0-9a-z_]+~i', '_', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '_'));
    }
}