<?php
namespace frontend\modules\main\controllers;

use common\models\Poll;
use frontend\modules\main\components\MainController;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PollController extends MainController
{

    public function actionIndex($poll_id)
    {
        $poll = Poll::find()
            ->with('choices')
            ->with('user')
            ->where(['id' => $poll_id])
            ->one();

        if (empty($poll)) {
            throw new NotFoundHttpException();
        }

        return $this->render('index', [
            'poll' => $poll
        ]);
    }

    public function vote($poll_id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return ['data' => true];
    }
}
