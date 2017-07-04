<?php

namespace common\clients;

use yii\authclient\clients\Facebook as FacebookClient;

class Facebook extends FacebookClient
{
//    protected $baseApiUrl = 'https://graph.facebook.com/v2.8/';


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
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        $data = $this->api('me', 'GET', [
            'fields' => implode(',', $this->attributeNames),
        ]);

        $data['photo_url'] = $this->apiBaseUrl . '/' .  $data['id'] . '/picture?width=100&height=100';

        return $data;
    }

}