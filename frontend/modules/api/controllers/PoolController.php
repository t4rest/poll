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

    public function actionIndex(): array
    {
        return $this->responseSuccess(
            $this->api->getPools()
        );
    }

    public function actionCreatePool(): array
    {
        return $this->responseSuccess(
            $this->api->createPool()
        );
    }

    public function actionUpdatePool($id): array
    {
        return $this->responseSuccess(
            $this->api->updatePool($id)
        );
    }

    public function actionDeletePool($id): array
    {
        return $this->responseSuccess(
            $this->api->deletePool($id)
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
