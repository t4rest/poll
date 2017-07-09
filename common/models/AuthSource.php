<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%auth_source}}".
 *
 * @property int $id
 * @property string $alias
 * @property string $title
 *
 * @property Auth[] $auths
 */
class AuthSource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_source}}';
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
    public function getAuths()
    {
        return $this->hasMany(Auth::className(), ['source_id' => 'id']);
    }
}
