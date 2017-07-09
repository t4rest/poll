<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%auth}}".
 *
 * @property string $id
 * @property int $source_id
 * @property int $user_id
 * @property string $token
 * @property string $data
 *
 * @property AuthSource $source
 * @property User $user
 */
class Auth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'source_id', 'user_id', 'token', 'data'], 'required'],
            [['source_id', 'user_id'], 'default', 'value' => null],
            [['source_id', 'user_id'], 'integer'],
            [['token', 'data'], 'string'],
            [['id'], 'string', 'max' => 128],
            [['id'], 'unique'],
            [['source_id'], 'exist', 'skipOnError' => true, 'targetClass' => AuthSource::className(), 'targetAttribute' => ['source_id' => 'id']],
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
            'source_id' => 'Source ID',
            'user_id' => 'User ID',
            'token' => 'Token',
            'data' => 'Data',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(AuthSource::className(), ['id' => 'source_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
