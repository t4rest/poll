<?php

namespace frontend\modules\api\controllers;

use backend\modules\user\api\Users;
use frontend\modules\api\components\MainController;
use common\pagination;
use Yii;

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
        $pagination = new pagination\OffsetBased(
            Yii::$app->request->get('offset', pagination\OffsetBased::DEFAULT_OFFSET),
            Yii::$app->request->get('limit', pagination\OffsetBased::DEFAULT_LIMIT)
        );

        $result = $this->api->userList(
            Yii::$app->request->get('search', []),
            Yii::$app->request->get('filter', []),
            $pagination
        );

        return $this->responseSuccess(
            $result,
            $pagination
        );
    }

    /**
     * @return array
     */
    public function actionIFollow(): array
    {
        $pagination = new pagination\OffsetBased(
            Yii::$app->request->get('offset', pagination\OffsetBased::DEFAULT_OFFSET),
            Yii::$app->request->get('limit', pagination\OffsetBased::DEFAULT_LIMIT)
        );

        $result = $this->api->iFollow(
            Yii::$app->request->get('search', []),
            Yii::$app->request->get('filter', []),
            $pagination
        );

        return $this->responseSuccess(
            $result,
            $pagination
        );
    }

    /**
     * @return array
     */
    public function actionMyFollowers(): array
    {
        $pagination = new pagination\OffsetBased(
            Yii::$app->request->get('offset', pagination\OffsetBased::DEFAULT_OFFSET),
            Yii::$app->request->get('limit', pagination\OffsetBased::DEFAULT_LIMIT)
        );

        $result = $this->api->myFollowers(
            Yii::$app->request->get('search', []),
            Yii::$app->request->get('filter', []),
            $pagination
        );

        return $this->responseSuccess(
            $result,
            $pagination
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
