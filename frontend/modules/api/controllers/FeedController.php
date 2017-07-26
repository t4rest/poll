<?php

namespace frontend\modules\api\controllers;

 use backend\modules\poll\api\Feed;
 use frontend\modules\api\components\MainController;

class FeedController extends MainController
{
    /**
     * @var Feed
     */
    public $api;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->api = new Feed();
        }
        return true;
    }

    public function actionFeed(): array
    {
        return $this->responseSuccess(
            $this->api->feed()
        );
    }

    public function actionVote($poll_id, $choice_id): array
    {
        return $this->responseSuccess(
            $this->api->vote($poll_id, $choice_id)
        );
    }

}
