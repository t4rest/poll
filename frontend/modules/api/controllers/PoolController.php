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

    public function actionDeletePool($pool_id): array
    {
        return $this->responseSuccess(
            $this->api->deletePool($pool_id)
        );
    }
}
