<?php

namespace common\clients;

use common\clients\auth\TokenHandler;
use common\models\Auth;
use common\models\Poll;
use Yii;
use yii\authclient\clients\Twitter as TwitterClient;
use yii\authclient\OAuthToken;

/**
 * Class Twitter
 * @package common\clients
 *
 * @property \common\models\Auth $clientToken
 * @property int $clientId
 */
class Twitter extends TwitterClient implements ClientInterface
{
    use StateStorage;

    const ID = 2;
    const CODE = 'twitter';

    /**
     * @return int]
     */
    public function getClientId(): int
    {
        return self::ID;
    }

    public function setClientToken(Auth $as)
    {
        $tokenOauth = new OAuthToken();
        $token = yii\helpers\Json::decode($as->token);
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

            $this->api('statuses/update.json', 'POST', [
                'status' => 'Hi how are you'
            ]);

            return true;
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            return false;
        }
    }

    /**
     * @param array $data
     * @return array
     */
    public function getUserDbAttributes(array $data = []): array
    {
        return [
            'username' => $data['screen_name'] ?? '',
            'email' => $data['email'] ?? '',
            'first_name' => $data['name'] ?? '',
            'last_name' => '',
            'photo_url' => $data['profile_image_url_https'] ?? '',
        ];
    }
}


// tw
//[id] => 2328742106
//[id_str] => 2328742106
//[name] => T4rest
//[screen_name] => t4rest_tw
//[location] =>
//[description] =>
//[url] =>
//[entities] => Array
//(
//    [description] => Array
//    (
//        [urls] => Array
//        (
//        )
//    )
//)
//
//[protected] =>
//[followers_count] => 0
//[friends_count] => 6
//[listed_count] => 0
//[created_at] => Wed Feb 05 12:52:01 +0000 2014
//[favourites_count] => 0
//[utc_offset] => 10800
//[time_zone] => Bucharest
//[geo_enabled] =>
//[verified] =>
//[statuses_count] => 0
//[lang] => ru
//[contributors_enabled] =>
//[is_translator] =>
//[is_translation_enabled] =>
//[profile_background_color] => C0DEED
//[profile_background_image_url] => http://abs.twimg.com/images/themes/theme1/bg.png
//[profile_background_image_url_https] => https://abs.twimg.com/images/themes/theme1/bg.png
//[profile_background_tile] =>
//[profile_image_url] => http://pbs.twimg.com/profile_images/865459558730276866/hx_gsgg-_normal.jpg
//[profile_image_url_https] => https://pbs.twimg.com/profile_images/865459558730276866/hx_gsgg-_normal.jpg
//[profile_banner_url] => https://pbs.twimg.com/profile_banners/2328742106/1428399916
//[profile_link_color] => 1DA1F2
//[profile_sidebar_border_color] => C0DEED
//[profile_sidebar_fill_color] => DDEEF6
//[profile_text_color] => 333333
//[profile_use_background_image] => 1
//[has_extended_profile] => 1
//[default_profile] => 1
//[default_profile_image] =>
//[following] =>
//[follow_request_sent] =>
//[notifications] =>
//[translator_type] => none