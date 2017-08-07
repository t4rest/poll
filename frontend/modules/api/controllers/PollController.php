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

    /**
     * @return array
     */
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

    /**
     * @param $poll_id
     * @return array
     */
    public function actionPoll($poll_id): array
    {
        return $this->responseSuccess(
            $this->api->getPoll($poll_id)
        );
    }

    /**
     * @return array
     */
    public function actionCreatePoll(): array
    {
        return $this->responseSuccess(
            $this->api->createPoll(
                Yii::$app->request->post('poll', []),
                Yii::$app->request->post('choices', [])
            )
        );
    }

    /**
     * @param $poll_id
     * @return array
     */
    public function actionDeletePoll($poll_id): array
    {
        return $this->responseSuccess(
            $this->api->deletePoll($poll_id)
        );
    }

    /**
     * @param $client
     * @param $poll_id
     * @return array
     */
    public function actionPost($poll_id, $client): array
    {
        return $this->responseSuccess(
            $this->api->post($poll_id, $client)
        );
    }
}
