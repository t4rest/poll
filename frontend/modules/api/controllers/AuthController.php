<?php

namespace frontend\modules\api\controllers;


use backend\controllers\BaseController;
use common\clients\auth\AuthHandlerMobile;

class AuthController extends BaseController
{
    /**
     * @var AuthHandlerMobile
     */
    public $api;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->api = new AuthHandlerMobile();
        }
        return true;
    }

    /**
     * @return array
     */
    public function actionIndex(): array
    {
        return $this->responseSuccess(
            $this->api->handle()
        );
    }
}
