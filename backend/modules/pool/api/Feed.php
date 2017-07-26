<?php

namespace backend\modules\poll\api;

use common\models\UserFriend;
use yii;
use common\models\Poll as PollModel;
use common\models\PollChoice;
use common\models\PollUserChoice;
use common\exceptions;

class Feed
{
    /**
     * @param array $filter
     * @return array|yii\db\ActiveRecord[]
     */
    public function feed(array $filter = [])
    {
        $subQuery = UserFriend::find()
            ->select('friend_id')
            ->where(['user_id' => Yii::$app->user->id]);

        $polls = PollModel::find()
            ->with(['choices', 'user', 'pollUserChoice' => function ($queryVote) {
                $queryVote->where(['user_id' => Yii::$app->user->id]);
            }])
            ->where(['user_id' => $subQuery])
            ->asArray()
            ->all();

        return $polls;
    }

    /**
     * @param $pollId
     * @param $choiceId
     * @return bool
     * @throws exceptions\RequestException
     */
    public function vote($pollId, $choiceId)
    {
        // todo: transactions
        $poll = PollModel::find()
            ->where(['id' => $pollId])
            ->one();

        $choice = PollChoice::find()
            ->where(['id' => $choiceId])
            ->one();

        if (empty($poll) || empty($choice)) {
            throw exceptions\RequestException::invalidRequest();
        }

        $choice->count += 1;
        $choice->save();

        $userChoice = PollUserChoice::find()
            ->where(['poll_id' => $pollId, 'user_id' => Yii::$app->user->id])
            ->one();

        if (!empty($userChoice)) {
            return true;
        }

        $userChoice = new PollUserChoice();
        $userChoice->user_id = Yii::$app->user->id;
        $userChoice->poll_id = $pollId;
        $userChoice->choice_id = $choiceId;
        $userChoice->setTime();

        if (!$userChoice->save()) {
            p($userChoice->errors);
        }

        return true;
    }

//    /**
//     * @param $pollId
//     * @return array]
//     */
//    public function getPollVotes($pollId): array
//    {
//        $polls = PollUserChoice::find()
//            ->with('choice')
//            ->with('user')
//            ->where(['id' => $pollId])
//            ->asArray()
//            ->all();
//
//        return $polls;
//    }
}