<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pool_user_choice}}".
 *
 * @property int $pool_id
 * @property int $user_id
 * @property int $choice_id
 * @property string $date
 *
 * @property Pool $pool
 * @property PoolChoice $choice
 * @property User $user
 */
class PoolUserChoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pool_user_choice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pool_id', 'user_id', 'choice_id', 'date'], 'required'],
            [['pool_id', 'user_id', 'choice_id'], 'default', 'value' => null],
            [['pool_id', 'user_id', 'choice_id'], 'integer'],
            [['date'], 'safe'],
            [['pool_id', 'user_id', 'choice_id'], 'unique', 'targetAttribute' => ['pool_id', 'user_id', 'choice_id']],
            [['pool_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pool::className(), 'targetAttribute' => ['pool_id' => 'id']],
            [['choice_id'], 'exist', 'skipOnError' => true, 'targetClass' => PoolChoice::className(), 'targetAttribute' => ['choice_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pool_id' => 'Pool ID',
            'user_id' => 'User ID',
            'choice_id' => 'Choice ID',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPool()
    {
        return $this->hasOne(Pool::className(), ['id' => 'pool_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChoice()
    {
        return $this->hasOne(PoolChoice::className(), ['id' => 'choice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
