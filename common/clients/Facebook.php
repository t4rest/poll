<?php

namespace common\clients;

use Yii;
use yii\authclient\clients\Facebook as FacebookClient;

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

    /**
     * @return bool
     */
    public function post(): bool
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
