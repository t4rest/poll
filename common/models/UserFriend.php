<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_friend}}".
 *
 * @property int $user_id
 * @property int $friend_id
 * @property string $date
 *
 * @property User $user
 * @property User $friend
 */
class UserFriend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_friend}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'friend_id', 'date'], 'required'],
            [['user_id', 'friend_id'], 'default', 'value' => null],
            [['user_id', 'friend_id'], 'integer'],
            [['date'], 'safe'],
            [['user_id', 'friend_id'], 'unique', 'targetAttribute' => ['user_id', 'friend_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['friend_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['friend_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'friend_id' => 'Friend ID',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFriend()
    {
        return $this->hasOne(User::className(), ['id' => 'friend_id']);
    }

}
