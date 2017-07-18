<?php

namespace backend\modules\pool\api;

use yii;
use common\models\PoolType;
use common\models\Pool as PoolModel;

class Pool
{
    /**
     * @param array $search
     * @param array $filter
     * @return array
     */
    public function getPools(array $search = [], array $filter = []): array
    {
        $pools = PoolModel::find()
            ->with('choices')
            ->where(['user_id' => Yii::$app->user->id])
            ->asArray()
            ->all();

        return $pools;
    }

    /**
     * @return array
     */
    public function createPool(): array
    {
        $pool = new PoolModel();

        return $pool->toArray();
    }

    /**
     * @param $id
     * @return array
     */
    public function getPool($id): array
    {
        $pool = new PoolModel();

        return $pool->toArray();
    }

    /**
     * @param $id
     * @return array
     */
    public function updatePool($id): array
    {
        $pool = new PoolModel();

        return $pool->toArray();
    }

    /**
     * @param $id
     * @return array
     */
    public function deletePool($id): array
    {
        $pool = new PoolModel();

        return $pool->toArray();
    }

    /**
     * @param $poolId
     */
    public function getChoices($poolId)
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
    }

    /**
     * @param $poolId
     * @return array
     */
    public function addChoice($poolId)
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
    }

    /**
     * @param $poolId
     * @param $choiceId
     * @return array
     */
    public function updateChoice($poolId, $choiceId)
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
    }

    /**
     * @param $poolId
     * @param $choiceId
     * @return array
     */
    public function deleteChoice($poolId, $choiceId)
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
    }
}