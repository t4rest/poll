<?php

namespace common\models;

use Yii;
use common\helper\Time;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $auth_key
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $photo_url
 * @property integer $country
 * @property integer $timezone
 * @property integer $locale
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $authKey
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            ['email', 'email'],
            [['country', 'timezone', 'locale'], 'integer'],
            ['username', 'unique'],
            [['username', 'first_name', 'last_name'], 'string', 'max' => 100],
            [['username', 'first_name', 'last_name', 'email', 'country', 'timezone', 'locale'], 'safe', 'on' => ['update']],
        ];
    }

    public function setTime()
    {
        $time = Time::getCurrentTime();
        if ($this->isNewRecord) {
            $this->created_at = $time;
        }
        $this->updated_at = $time;
    }



    /**
     * @param int|string $id
     * @return static
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return array|null|User
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int)$this->getPrimaryKey();
    }

    /**
     * @return string
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     *
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function getFriends()
    {
        return $this->hasOne(UserFriend::className(), ['friend_id' => 'id']);
    }
}
