<?php

namespace frontend\modules\api\controllers;

use backend\modules\poll\api\Poll;
use frontend\modules\api\components\MainController;

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
        return $this->responseSuccess(
            $this->api->getPolls()
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
            $this->api->createPoll()
        );
    }

    public function actionDeletePoll($poll_id): array
    {
        return $this->responseSuccess(
            $this->api->deletePoll($poll_id)
        );
    }
}
