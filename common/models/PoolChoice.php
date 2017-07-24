<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pool_choice}}".
 *
 * @property int $id
 * @property int $pool_id
 * @property string $data
 * @property int $count
 *
 * @property Pool $pool
 * @property PoolUserChoice[] $poolUserChoices
 */
class PoolChoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pool_choice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pool_id', 'data', 'count'], 'required'],
            [['pool_id', 'count'], 'default', 'value' => null],
            [['pool_id', 'count'], 'integer'],
            [['data'], 'string', 'max' => 255],
            [['pool_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pool::className(), 'targetAttribute' => ['pool_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pool_id' => 'Pool ID',
            'data' => 'Data',
            'count' => 'Count',
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
    public function getPoolUserChoices()
    {
        return $this->hasMany(PoolUserChoice::className(), ['choice_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoolUserChoice()
    {
        return $this->hasOne(PoolUserChoice::className(), ['choice_id' => 'id']);
    }
}
