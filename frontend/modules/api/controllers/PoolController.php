<?php

namespace frontend\modules\api\controllers;

use backend\modules\pool\api\Pool;
use frontend\modules\api\components\MainController;

class PoolController extends MainController
{
    /**
     * @var Pool
     */
    public $api;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->api = new Pool();
        }
        return true;
    }

    public function actionPools(): array
    {
        return $this->responseSuccess(
            $this->api->getPools()
        );
    }

    public function actionPool($pool_id): array
    {
        return $this->responseSuccess(
            $this->api->getPool($pool_id)
        );
    }

    public function actionCreatePool(): array
    {
        return $this->responseSuccess(
            $this->api->createPool()
        );
    }

    public function actionUpdatePool($pool_id): array
    {
        return $this->responseSuccess(
            $this->api->updatePool($pool_id)
        );
    }

    public function actionDeletePool($pool_id): array
    {
        return $this->responseSuccess(
            $this->api->deletePool($pool_id)
        );
    }


















    public function actionChoices($poolId): array
    {
        return $this->responseSuccess(
            $this->api->getChoices($poolId)
        );
    }

    public function actionAddChoice($poolId): array
    {
        return $this->responseSuccess(
            $this->api->addChoice($poolId)
        );
    }

    public function actionUpdateChoice($poolId, $choiceId): array
    {
        return $this->responseSuccess(
            $this->api->updateChoice($poolId, $choiceId)
        );
    }

    public function actionDeleteChoice($poolId, $choiceId): array
    {
        return $this->responseSuccess(
            $this->api->deleteChoice($poolId, $choiceId)
        );
    }

}
