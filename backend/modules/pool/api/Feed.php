<?php

namespace backend\modules\pool\api;

use yii;
use common\models\Pool as PoolModel;
use common\models\PoolChoice;
use common\models\PoolUserChoice;
use common\exceptions;
class Feed
{
    /**
     * @param array $filter
     * @return array|yii\db\ActiveRecord[]
     */
    public function feed(array $filter = [])
    {
        $pools = PoolModel::find()
            ->with('choices')
            ->where(['user_id' => Yii::$app->user->id])
            ->asArray()
            ->all();

        return $pools;
    }

    /**
     * @param $poolId
     * @param $choiceId
     * @return bool
     * @throws exceptions\RequestException
     */
    public function vote($poolId, $choiceId)
    {
        // todo: transactions
        $pool = PoolModel::find()
            ->where(['id' => $poolId])
            ->one();

        $choice = PoolChoice::find()
            ->where(['id' => $choiceId])
            ->one();

        if (empty($pool) || empty($choice)) {
            throw exceptions\RequestException::invalidRequest();
        }

        $choice->count += 1;
        $choice->save();

        $userChoice = PoolUserChoice::find()
            ->where(['pool_id' => $poolId, 'user_id' => Yii::$app->user->id])
            ->one();

        if(!empty($userChoice)) {
            return true;
        }

        $userChoice = new PoolUserChoice();
        $userChoice->user_id = Yii::$app->user->id;
        $userChoice->pool_id = $poolId;
        $userChoice->choice_id = $choiceId;
        $userChoice->save();

        return true;
    }

//    /**
//     * @param $poolId
//     * @return array]
//     */
//    public function getPoolVotes($poolId): array
//    {
//        $pools = PoolUserChoice::find()
//            ->with('choice')
//            ->with('user')
//            ->where(['id' => $poolId])
//            ->asArray()
//            ->all();
//
//        return $pools;
//    }
}