<?php

namespace backend\modules\poll\api;

use common\clients\auth\BaseAuthHandler;
use common\clients\auth\TokenHandler;
use common\clients\ClientInterface;
use common\clients\Facebook;
use common\clients\Twitter;
use common\exceptions;
use common\models\Auth;
use common\models\UploadPollPhoto;
use yii;
use common\models\Poll as PollModel;
use common\models\PollChoice;
use yii\authclient\OAuthToken;
use yii\helpers\Json;
use yii\web\UploadedFile;
use common\pagination;

class Poll
{

    /**
     * @param array $search
     * @param array $filter
     * @param pagination\OffsetBased $pagination
     * @return array
     */
    public function getPolls(array $search = [], array $filter = [], pagination\OffsetBased $pagination): array
    {
        $polls = PollModel::find()
            ->with('choices')
            ->where(['user_id' => Yii::$app->user->id])
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
     * todo: refactor this method
     * @param $pollPost
     * @param $choicesPost
     * @return array
     * @throws exceptions\RequestException
     * @throws yii\base\Exception
     */
    public function createPoll($pollPost, $choicesPost): array
    {
        if (empty($pollPost) || empty($choicesPost)) {
            throw exceptions\RequestException::invalidRequest();
        }

        $image = new UploadPollPhoto();
        $image->image = UploadedFile::getInstanceByName('image');

        $tr = PollModel::getDb()->beginTransaction();

        try {
            $choicesArr = [];
            $poll = new PollModel();
            $poll->setAttributes($pollPost);
            $poll->user_id = Yii::$app->user->id;
            $poll->setTime();


            if ($image->image && !$image->validate()) {
                throw exceptions\RequestException::invalidRequestError($image->getErrors());
            }

            if ($image->image && $image->upload()) {
                $poll->photo_url = $image->imageWebPath;
            }

            if (!$poll->save()) {
                throw exceptions\RequestException::invalidRequestError($poll->getErrors());
            }
            $result = $poll->toArray();

            foreach ($choicesPost as $item) {
                $choice = new PollChoice();
                $choice->text = $item;
                $choice->poll_id = $poll->id;
                $choice->count = 0;
                if (!$choice->save()) {
                    throw exceptions\RequestException::invalidRequestError($poll->getErrors());
                }
                $choicesArr[] = $choice->toArray();
            }
            $result['choices'] = $choicesArr;

            $tr->commit();
        } catch (yii\base\Exception $e) {
            $tr->rollBack();

            if ($image->imagePath) {
                $image->deleteImage();
            }

            throw $e;
        }


        return $result;
    }

    /**
     * @param $id
     * @return array
     * @throws exceptions\AccessException
     * @throws exceptions\DatabaseException
     */
    public function getPoll($id): array
    {
        $poll = PollModel::find()
            ->with('choices')
            ->where(['id' => $id])
            ->asArray()
            ->one();

        if (!$poll) {
            throw exceptions\DatabaseException::recordNotFound('Poll does not exists');
        }

        if ($poll->user_id != Yii::$app->user->id) {
            throw exceptions\AccessException::deniedPermission();
        }

        return $poll;
    }

    /**
     * @param $id
     * @return bool
     * @throws exceptions\AccessException
     * @throws exceptions\DatabaseException
     */
    public function deletePoll($id): bool
    {
        $poll = PollModel::findone($id);

        if (!$poll) {
            throw exceptions\DatabaseException::recordNotFound('Poll does not exists');
        }

        if ($poll->user_id != Yii::$app->user->id) {
            throw exceptions\AccessException::deniedPermission();
        }

        return (bool)$poll->delete();
    }

    public function post($id, $client)
    {
        $poll = PollModel::findone($id);

        if (!$poll) {
            throw exceptions\DatabaseException::recordNotFound('Poll does not exists');
        }

        if ($poll->user_id != Yii::$app->user->id) {
            throw exceptions\AccessException::deniedPermission();
        }

        BaseAuthHandler::validateClient($client);

        /**
         * @var ClientInterface|Facebook|Twitter $clientApi
         */
        $clientApi = Yii::$app->authClientCollection->getClient($client);

        $as = Auth::find()
            ->where(['user_id' => Yii::$app->user->id, 'source_id' => $clientApi->getClientId()])
            ->one();

        if (empty($as)) {
            throw exceptions\DatabaseException::recordNotFound("Client {$client} does not exists");
        }

        $token = Json::decode($as->token);

        $tokenOauth = new OAuthToken();
        if ($client == Facebook::CODE) {
            $tokenOauth->tokenParamKey = 'access_token';
        }
        $tokenOauth->setParams($token);

        if ($tokenOauth->getIsExpired() && $clientApi->autoRefreshAccessToken) {
            $tokenOauth = $clientApi->refreshAccessToken($tokenOauth);

            $tokenHandler = new TokenHandler();
            $tokenHandler->client = $clientApi;
            $tokenHandler->saveAuthClient($as->user_id, $as);
        }

        $clientApi->setAccessToken($tokenOauth);

        return $clientApi->post($poll);
    }

//    /**
//     * @param $id
//     * @return array
//     * @throws exceptions\DatabaseException
//     */
//    public function updatePoll($id): array
//    {
//        $poll = PollModel::findOne($id);
//
//
//        $poll->setAttributes(Yii::$app->request->getBodyParams());
//
//        $model = new UploadPollPhoto();
//        $model->image = UploadedFile::getInstanceByName('image');
//        if ($model->image && $model->upload(Yii::$app->user->id)) {
//            $poll->photo_url = $model->imagePath;
//        }
//
//        if (!$poll->save()) {
//            throw exceptions\DatabaseException::recordOperationFail();
//        }
//
//        return $poll->toArray();
//    }
//
//    /**
//     * @param $pollId
//     * @return array
//     */
//    public function getChoices($pollId)
//    {
//        $pollChoices = PollChoice::find()
//            ->where(['poll' => $pollId])
//            ->asArray()
//            ->all();
//
//        return $pollChoices;
//    }
//
//    /**
//     * @param $pollId
//     * @return array
//     */
//    public function addChoice($pollId)
//    {
//        $pollChoice = PollChoice::find()
//            ->where(['poll' => $pollId])
//            ->asArray()
//            ->one();
//
//        return $pollChoice;
//    }
//
//    /**
//     * @param $pollId
//     * @param $choiceId
//     * @return array
//     */
//    public function updateChoice($pollId, $choiceId)
//    {
//        $pollChoice = PollChoice::find()
//            ->where([
//                'poll' => $pollId,
//                'id' => $choiceId,
//            ])
//            ->asArray()
//            ->one();
//
//        return $pollChoice;
//    }
//
//    /**
//     * @param $pollId
//     * @param $choiceId
//     * @return array
//     */
//    public function deleteChoice($pollId, $choiceId)
//    {
//        $pollChoice = PollChoice::find()
//            ->where([
//                'poll' => $pollId,
//                'id' => $choiceId,
//            ])
//            ->asArray()
//            ->one();
//
//        return $pollChoice;
//    }
}