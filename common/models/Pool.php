<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pool}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $type_id
 * @property int $is_hot
 * @property string $photo_url
 * @property string $data
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PoolType $type
 * @property User $user
 * @property PoolChoice[] $poolChoices
 * @property PoolUserChoice[] $poolUserChoices
 */
class Pool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pool}}';
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
            [['photo_url', 'data'], 'string', 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PoolType::className(), 'targetAttribute' => ['type_id' => 'id']],
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
            'photo_url' => 'Photo Url',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(PoolType::className(), ['id' => 'type_id']);
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
        return $this->hasMany(PoolChoice::className(), ['pool_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoolUserChoices()
    {
        return $this->hasMany(PoolUserChoice::className(), ['pool_id' => 'id']);
    }
}
