<?php

namespace frontend\modules\api\controllers;

use backend\modules\user\api\User;
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
            $this->api = new User();
        }
        return true;
    }

    /**
     * @return array
     */
    public function actionIndex()
    {
        return $this->api->info();
    }

    public function actionUpdate()
    {
        return $this->api->info();
    }


}
