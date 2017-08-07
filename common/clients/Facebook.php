<?php

namespace common\clients;

use common\clients\auth\TokenHandler;
use yii\helpers\Json;
use common\models\Auth;
use common\models\Poll;
use Yii;
use yii\authclient\clients\Facebook as FacebookClient;
use yii\authclient\OAuthToken;

/**
 *
 * @property \common\models\Auth $clientToken
 */
class Facebook extends FacebookClient implements ClientInterface
{
    use StateStorage;

    const ID = 1;
    const CODE = 'facebook';

    public $scope = 'public_profile,email,user_friends,publish_actions';

    public $attributeNames = [
        'id',
        'name',
        'link',
        'email',
        'verified',
        'first_name',
        'last_name',
        'gender',
        'birthday',
        'hometown',
        'location',
        'locale',
        'timezone',
        'updated_time',
    ];

    /**
     * @param Auth $as
     */
    public function setClientToken(Auth $as)
    {
        $tokenOauth = new OAuthToken();
        $tokenOauth->tokenParamKey = 'access_token';
        $token = Json::decode($as->token);
        $tokenOauth->createTimestamp = $token['created_at'] ?? time();
        $tokenOauth->setParams($token);

        if ($tokenOauth->getIsExpired() && $this->autoRefreshAccessToken) {
            $tokenOauth = $this->refreshAccessToken($tokenOauth);

            $tokenHandler = new TokenHandler();
            $tokenHandler->client = $this;
            $tokenHandler->saveAuthClient($as->user_id, $as);
        }

        parent::setAccessToken($token);
    }

    /**
     * @param Poll $poll
     * @return bool
     */
    public function post(Poll $poll): bool
    {
        try {

            $params = array(
                "access_token" => $this->getAccessToken()->token,
                "message" => "#php #facebook",
                "description" => "How to create a Facebook app."
            );

            $this->api('/me/feed', 'POST', $params);

            return true;
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            return false;
        }
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return self::ID;
    }

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        $data = parent::initUserAttributes();

        $data['photo_url'] = $this->apiBaseUrl . '/' . $data['id'] . '/picture?width=100&height=100';

        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    public function getUserDbAttributes(array $data = []): array
    {
        return [
            'username' => $data['name'] ?? '',
            'email' => $data['email'] ?? '',
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'photo_url' => $data['photo_url'] ?? '',
        ];
    }
}

//fb
//[id] => 1870695869864017
//[name] => Andrey  Anisimov
//[link] => https://www.facebook.com/app_scoped_user_id/1870695869864017/
//[email] => andrey.anisimov.mail@gmail.com
//[verified] => 1
//[first_name] => Andrey
//[last_name] => Anisimov
//[gender] => male
//[locale] => en_US
//[timezone] => 3
//[updated_time] => 2017-05-17T17:33:00+0000
//[photo_url] => https://graph.facebook.com/1870695869864017/picture?width=100&height=100
