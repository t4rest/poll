<?php

namespace backend\modules\poll\api;

use common\exceptions;
use common\models\UploadPollPhoto;
use common\models\UploadPollPhotos;
use yii;
use common\models\Poll as PollModel;
use common\models\PollChoice;
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

        $tr = PollModel::getDb()->beginTransaction();

        try {

            $poll = new PollModel();
            $poll->setAttributes($pollPost);
            $poll->user_id = Yii::$app->user->id;
            $poll->setTime();

            $images = new UploadPollPhotos();
            $images->images = UploadedFile::getInstancesByName('images');

            if ($images->images && !$images->validate()) {
                throw exceptions\RequestException::invalidRequest('images');
            }

            if ($images->images && $images->upload()) {
                $poll->photos_url = $images->imagesWebPath;
            }

            $image = new UploadPollPhoto();
            $image->image = UploadedFile::getInstanceByName('image');


            if ($image->image && !$image->validate()) {
                $images->deleteImages();
                throw exceptions\RequestException::invalidRequest('images');
            }

            if ($image->image && $image->upload()) {

                $poll->photo_url = $image->imageWebPath;
            }


            if (!$poll->save()) {
//                $images->deleteImages();
//                $image->deleteImage();

                p($poll->errors);
                throw exceptions\DatabaseException::recordOperationFail();
            }

            foreach ($choicesPost as $item) {
                $choice = new PollChoice();
                $choice->data = $item;
                $choice->poll_id = $poll->id;
                $choice->count = 0;
                if (!$choice->save()) {
                    $images->deleteImages();
                    $image->deleteImage();

                    p($poll->errors);
                    throw exceptions\DatabaseException::recordOperationFail();
                }
            }

            $tr->commit();
        } catch (yii\base\Exception $e) {
            $tr->rollBack();
            throw $e;
        }

        return $poll->toArray();
    }

    /**
     * @param $id
     * @return array
     * @throws exceptions\DatabaseException
     */
    public function getPoll($id): array
    {
        $poll = PollModel::find()
            ->with('choices')
            ->where(['id' => $id])
            ->asArray()
            ->one();

        return $poll;
    }


    /**
     * @param $id
     * @return bool
     * @throws exceptions\RequestException
     */
    public function deletePoll($id): bool
    {
        $poll = PollModel::findone($id);

        if (!$poll) {
            throw exceptions\RequestException::invalidRequest('Poll does not exists');
        }

        $poll->delete();

        return true;
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