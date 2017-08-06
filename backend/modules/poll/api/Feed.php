<?php

namespace backend\modules\poll\api;

use common\models\UserFriend;
use yii;
use common\models\Poll as PollModel;
use common\models\PollChoice;
use common\models\PollUserChoice;
use common\exceptions;
use common\pagination;

class Feed
{
    /**
     * @param array $search
     * @param array $filter
     * @param pagination\OffsetBased $pagination
     * @return array|yii\db\ActiveRecord[]
     */
    public function feed(array $search = [], array $filter = [], pagination\OffsetBased $pagination)
    {
        $subQuery = UserFriend::find()
            ->select('friend_id')
            ->where(['user_id' => Yii::$app->user->id]);

        $polls = PollModel::find()
            ->with(['choices', 'user', 'pollUserChoice' => function (\yii\db\ActiveQuery $queryVote) {
                $queryVote->where(['user_id' => Yii::$app->user->id]);
            }])
            ->where(['user_id' => $subQuery])
            ->limit($pagination->getLimit() + 1) // in this way we check if we have next paginated page
            ->offset($pagination->getOffset())
            ->asArray()
            ->all();

        if (count($polls) > $pagination->getLimit()) {

            /**
             * remove extra last element from array if count more than limit
             * to avoid extra query to db
             */
            $pagination->setNext(true);
            array_pop($polls);
        }

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

        $userChoice = PollUserChoice::find()
            ->where(['poll_id' => $pollId, 'user_id' => Yii::$app->user->id])
            ->one();

        if (!empty($userChoice)) {
            return true;
        }

        $choice->count += 1;
        if (!$choice->save()) {
            throw exceptions\RequestException::invalidRequestError($choice->getErrors());
        }

        $userChoice = new PollUserChoice();
        $userChoice->user_id = Yii::$app->user->id;
        $userChoice->poll_id = $pollId;
        $userChoice->choice_id = $choiceId;
        $userChoice->setTime();

        if (!$userChoice->save()) {
            throw exceptions\RequestException::invalidRequestError($userChoice->getErrors());
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