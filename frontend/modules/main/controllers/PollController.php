<?php
namespace frontend\modules\main\controllers;

use backend\modules\poll\api\Feed;
use common\models\Poll;
use common\models\User;
use frontend\modules\main\components\MainController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PollController extends MainController
{

    public function init()
    {
        parent::init();

        if (Yii::$app->user->isGuest) {
            $user = User::createHeadlessUser();
            Yii::$app->user->login($user, 60*60*24*100000);
        }
    }

    public function actionIndex($poll_id)
    {
        $poll = Poll::find()
            ->with(['choices' => function (\yii\db\ActiveQuery $queryChoice) {
                $queryChoice->orderBy('id');
            }, 'pollUserChoice' => function (\yii\db\ActiveQuery $queryVote) {
                $queryVote->where(['user_id' => Yii::$app->user->id]);
            }])
            ->with('user')
            ->where(['id' => $poll_id])
            ->one();

//        p($poll);

        if (empty($poll)) {
            throw new NotFoundHttpException();
        }

        return $this->render('index', [
            'poll' => $poll
        ]);
    }

    public function actionVote($poll_id, $choice_id)
    {
        $poll = new Feed();
        $poll->vote($poll_id, $choice_id);

        return $this->redirect(['index', 'poll_id' => $poll_id]);
    }
}
