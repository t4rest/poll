<?php

namespace backend\modules\pool\api;

 use yii;
use common\models\Pool as PoolModel;
use common\models\PoolChoice;
use common\models\PoolUserChoice;

class Feed
{

    public function feed(array $filter = [])
    {
        $pools = PoolModel::find()
            ->with('choices')
            ->where(['user_id' => Yii::$app->user->id])
            ->asArray()
            ->all();

        return $pools;
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