<?php

namespace frontend\modules\api\controllers;

use backend\modules\user\api\Users;
use frontend\modules\api\components\MainController;

class UsersController extends MainController
{
    /**
     * @var Users
     */
    public $api;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->api = new Users();
        }
        return true;
    }

    /**
     * @return array
     */
    public function actionIndex(): array
    {
        return $this->responseSuccess(
            $this->api->userList()
        );
    }

    /**
     * @return array
     */
    public function actionIFollow(): array
    {
        return $this->responseSuccess(
            $this->api->iFollow()
        );
    }

    /**
     * @return array
     */
    public function actionMyFollowers(): array
    {
        return $this->responseSuccess(
            $this->api->myFollowers()
        );
    }


    /**
     * @param $user_id
     * @return array
     */
    public function actionFollow($user_id): array
    {
        return $this->responseSuccess(
            $this->api->follow($user_id)
        );
    }

    /**
     * @param $user_id
     * @return array
     */
    public function actionUnfollow($user_id): array
    {
        return $this->responseSuccess(
            $this->api->unfollow($user_id)
        );
    }

}
