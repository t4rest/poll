<?php

namespace backend\modules\user\controllers;

use backend\controllers\AuthController;
use backend\modules\user\api\User as UserApi;


class UserController extends AuthController
{
    public $api;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->api = new UserApi();
        }
        return true;
    }
}