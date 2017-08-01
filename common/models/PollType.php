<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%poll_type}}".
 *
 * @property int $id
 * @property string $alias
 * @property string $title
 *
 * @property Poll[] $polls
 */
class PollType extends ActiveRecord
{
    const POLL_TYPE_TEXT = 1;
    const POLL_TYPE_SINGLE_PHOTO = 2;
    const POLL_TYPE_PHOTO_COMPARISON = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%poll_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'alias', 'title'], 'required'],
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['alias'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 20],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alias' => 'Alias',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolls()
    {
        return $this->hasMany(Poll::className(), ['type_id' => 'id']);
    }

    public static function getTypes()
    {
        return self::find()
            ->asArray()
            ->indexBy('id')
            ->all();
    }
}
