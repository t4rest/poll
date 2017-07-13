<?php

namespace frontend\modules\api\controllers;

use backend\modules\pool\api\Pool;
use frontend\modules\api\components\MainController;

class UserController extends MainController
{
    /**
     * @var User
     */
    public $api;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->api = new Pool();
        }
        return true;
    }

    /**
     * @return array
     */
    public function actionIndex(): array
    {
        return $this->responseSuccess(
            $this->api->info()
        );
    }


}
