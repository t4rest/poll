<?php

namespace common\models;

use common\helper\Time;
use Yii;

/**
 * This is the model class for table "{{%poll_user_choice}}".
 *
 * @property int $poll_id
 * @property int $user_id
 * @property int $choice_id
 * @property string $date
 *
 * @property Poll $poll
 * @property PollChoice $choice
 * @property User $user
 */
class PollUserChoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%poll_user_choice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['poll_id', 'user_id', 'choice_id', 'date'], 'required'],
            [['poll_id', 'user_id', 'choice_id'], 'default', 'value' => null],
            [['poll_id', 'user_id', 'choice_id'], 'integer'],
            [['date'], 'safe'],
            [['poll_id', 'user_id', 'choice_id'], 'unique', 'targetAttribute' => ['poll_id', 'user_id', 'choice_id']],
            [['poll_id'], 'exist', 'skipOnError' => true, 'targetClass' => Poll::className(), 'targetAttribute' => ['poll_id' => 'id']],
            [['choice_id'], 'exist', 'skipOnError' => true, 'targetClass' => PollChoice::className(), 'targetAttribute' => ['choice_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'poll_id' => 'Poll ID',
            'user_id' => 'User ID',
            'choice_id' => 'Choice ID',
            'date' => 'Date',
        ];
    }

    public function setTime()
    {
        if ($this->isNewRecord) {
            $this->date = Time::getCurrentTime();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoll()
    {
        return $this->hasOne(Poll::className(), ['id' => 'poll_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChoice()
    {
        return $this->hasOne(PollChoice::className(), ['id' => 'choice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
