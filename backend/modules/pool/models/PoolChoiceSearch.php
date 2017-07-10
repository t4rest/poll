<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PoolChoice;

/**
 * PoolChoiceSearch represents the model behind the search form of `common\models\PoolChoice`.
 */
class PoolChoiceSearch extends PoolChoice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pool_id', 'count'], 'integer'],
            [['data'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PoolChoice::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'pool_id' => $this->pool_id,
            'count' => $this->count,
        ]);

        $query->andFilterWhere(['ilike', 'data', $this->data]);

        return $dataProvider;
    }
}
