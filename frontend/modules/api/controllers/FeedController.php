<?php

namespace frontend\modules\api\controllers;

use backend\modules\poll\api\Feed;
use frontend\modules\api\components\MainController;
use common\pagination;
use Yii;

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
        $pagination = new pagination\OffsetBased(
            Yii::$app->request->get('offset', pagination\OffsetBased::DEFAULT_OFFSET),
            Yii::$app->request->get('limit', pagination\OffsetBased::DEFAULT_LIMIT)
        );

        $result = $this->api->feed(
            Yii::$app->request->get('search', []),
            Yii::$app->request->get('filter', []),
            $pagination
        );

        return $this->responseSuccess(
            $result,
            $pagination
        );
    }

    public function actionVote($poll_id, $choice_id): array
    {
        return $this->responseSuccess(
            $this->api->vote($poll_id, $choice_id)
        );
    }

}
