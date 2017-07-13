<?php

namespace backend\modules\pool\api;

use common\models\UploadAvatar;
use backend\modules\user\datatypes\UserStructure;
use yii;
use common\models\User as UserModel;
use yii\web\UploadedFile;

class Pool
{
    /**
     * @return array
     */
    public function getPools(): array
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
    }

    /**
     * @return array
     */
    public function createPool(): array
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
    }

    /**
     * @param $id
     * @return array
     */
    public function getPool($id): array
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
    }

    /**
     * @param $id
     * @return array
     */
    public function updatePool($id): array
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
    }

    /**
     * @param $id
     * @return array
     */
    public function deletePool($id): array
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
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
    public function addChoices($poolId)
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
    }

    /**
     * @param $poolId
     * @param $choiceId
     * @return array
     */
    public function updateChoices($poolId, $choiceId)
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
    }

    /**
     * @param $poolId
     * @param $choiceId
     * @return array
     */
    public function deleteChoices($poolId, $choiceId)
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
    }
}