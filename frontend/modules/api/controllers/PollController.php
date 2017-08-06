<?php

namespace frontend\modules\api\controllers;

use backend\modules\poll\api\Poll;
use frontend\modules\api\components\MainController;
use common\pagination;
use Yii;

class PollController extends MainController
{
    /**
     * @var Poll
     */
    public $api;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->api = new Poll();
        }
        return true;
    }

    public function actionPolls(): array
    {
        $pagination = new pagination\OffsetBased(
            Yii::$app->request->get('offset', pagination\OffsetBased::DEFAULT_OFFSET),
            Yii::$app->request->get('limit', pagination\OffsetBased::DEFAULT_LIMIT)
        );

        $result = $this->api->getPolls(
            Yii::$app->request->get('search', []),
            Yii::$app->request->get('filter', []),
            $pagination
        );

        return $this->responseSuccess(
            $result,
            $pagination
        );
    }

    public function actionPoll($poll_id): array
    {
        return $this->responseSuccess(
            $this->api->getPoll($poll_id)
        );
    }

    public function actionCreatePoll(): array
    {
        return $this->responseSuccess(
            $this->api->createPoll(
                Yii::$app->request->post('poll', []),
                Yii::$app->request->post('choices', [])
            )
        );
    }

    public function actionDeletePoll($poll_id): array
    {
        return $this->responseSuccess(
            $this->api->deletePoll($poll_id)
        );
    }
}
