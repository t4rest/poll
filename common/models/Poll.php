<?php

namespace common\models;

use common\helper\Time;
use Yii;

/**
 * This is the model class for table "{{%poll}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $type_id
 * @property int $is_hot
 * @property string $photos_url
 * @property string $data
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PollType $type
 * @property User $user
 * @property PollChoice[] $pollChoices
 * @property PollUserChoice[] $pollUserChoices
 */
class Poll extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%poll}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type_id', 'data', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'type_id', 'is_hot'], 'default', 'value' => null],
            [['user_id', 'type_id', 'is_hot'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['photos_url'], 'each', 'rule' => ['string']],
            [['data'], 'string', 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PollType::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type_id' => 'Type ID',
            'is_hot' => 'Is Hot',
            'photos_url' => 'Photo Url',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(PollType::className(), ['id' => 'type_id']);
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
    public function getChoices()
    {
        return $this->hasMany(PollChoice::className(), ['poll_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPollUserChoices()
    {
        return $this->hasMany(PollUserChoice::className(), ['poll_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPollUserChoice()
    {
        return $this->hasOne(PollUserChoice::className(), ['poll_id' => 'id']);
    }
}
