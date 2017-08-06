<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%poll_choice}}".
 *
 * @property int $id
 * @property int $poll_id
 * @property string $text
 * @property int $count
 *
 * @property Poll $poll
 * @property PollUserChoice[] $pollUserChoices
 */
class PollChoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%poll_choice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['poll_id', 'text', 'count'], 'required'],
            [['poll_id', 'count'], 'default', 'value' => null],
            [['poll_id', 'count'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['poll_id'], 'exist', 'skipOnError' => true, 'targetClass' => Poll::className(), 'targetAttribute' => ['poll_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'poll_id' => 'Poll ID',
            'text' => 'Text',
            'count' => 'Count',
        ];
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
    public function getPollUserChoices()
    {
        return $this->hasMany(PollUserChoice::className(), ['choice_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPollUserChoice()
    {
        return $this->hasOne(PollUserChoice::className(), ['choice_id' => 'id']);
    }
}
