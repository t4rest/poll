<?php

namespace backend\modules\pool\api;

use common\exceptions;
use common\models\UploadPoolPhoto;
use yii;
use common\models\Pool as PoolModel;
use common\models\PoolChoice;
use yii\web\UploadedFile;

class Pool
{

    /**
     * @param array $search
     * @param array $filter
     * @return array
     */
    public function getPools(array $search = [], array $filter = []): array
    {
        $pools = PoolModel::find()
            ->with('choices')
            ->where(['user_id' => Yii::$app->user->id])
            ->asArray()
            ->all();

        return $pools;
    }

    /**
     * @return array
     * @throws yii\base\Exception
     */
    public function createPool(): array
    {
        $tr = PoolModel::getDb()->beginTransaction();
        $poolPost = Yii::$app->request->post('pool', []);
        $choicesPost = Yii::$app->request->post('choices', []);



        if (empty($poolPost) || empty($choicesPost)) {
            throw exceptions\RequestException::invalidRequest();
        }

        try {

            $pool = new PoolModel();
            $pool->setAttributes($poolPost);
            $pool->user_id = Yii::$app->user->id;
            $pool->setTime();

            $images = new UploadPoolPhoto();
            $images->images = UploadedFile::getInstancesByName('images');

            if ($images->images && !$images->validate()) {
                throw exceptions\RequestException::invalidRequest('images');
            }

            if ($images->images && $images->upload()) {
                $pool->photos_url = $images->imagesPath;
            }

            if (!$pool->save()) {
                $images->deleteImages();

                p($pool->errors);
                throw exceptions\DatabaseException::recordOperationFail();
            }

            foreach ($choicesPost as $item) {
                $choice = new PoolChoice();
                $choice->data = $item;
                $choice->pool_id = $pool->id;
                $choice->count = 0;
                if (!$choice->save()) {
                    $images->deleteImages();

                    p($pool->errors);
                    throw exceptions\DatabaseException::recordOperationFail();
                }
            }


            $tr->commit();
        } catch (yii\base\Exception $e) {
            $tr->rollBack();
            throw $e;
        }

        return $pool->toArray();
    }

    /**
     * @param $id
     * @return array
     * @throws exceptions\DatabaseException
     */
    public function getPool($id): array
    {
        $pool = PoolModel::find()
            ->with('choices')
            ->where(['id' => $id])
            ->asArray()
            ->one();

        return $pool;
    }


    /**
     * @param $id
     * @return bool
     */
    public function deletePool($id): bool
    {
        $pool = PoolModel::findone($id);

        return $pool->delete();
    }

//    /**
//     * @param $id
//     * @return array
//     * @throws exceptions\DatabaseException
//     */
//    public function updatePool($id): array
//    {
//        $pool = PoolModel::findOne($id);
//
//
//        $pool->setAttributes(Yii::$app->request->getBodyParams());
//
//        $model = new UploadPoolPhoto();
//        $model->image = UploadedFile::getInstanceByName('image');
//        if ($model->image && $model->upload(Yii::$app->user->id)) {
//            $pool->photo_url = $model->imagePath;
//        }
//
//        if (!$pool->save()) {
//            throw exceptions\DatabaseException::recordOperationFail();
//        }
//
//        return $pool->toArray();
//    }
//
//    /**
//     * @param $poolId
//     * @return array
//     */
//    public function getChoices($poolId)
//    {
//        $poolChoices = PoolChoice::find()
//            ->where(['pool' => $poolId])
//            ->asArray()
//            ->all();
//
//        return $poolChoices;
//    }
//
//    /**
//     * @param $poolId
//     * @return array
//     */
//    public function addChoice($poolId)
//    {
//        $poolChoice = PoolChoice::find()
//            ->where(['pool' => $poolId])
//            ->asArray()
//            ->one();
//
//        return $poolChoice;
//    }
//
//    /**
//     * @param $poolId
//     * @param $choiceId
//     * @return array
//     */
//    public function updateChoice($poolId, $choiceId)
//    {
//        $poolChoice = PoolChoice::find()
//            ->where([
//                'pool' => $poolId,
//                'id' => $choiceId,
//            ])
//            ->asArray()
//            ->one();
//
//        return $poolChoice;
//    }
//
//    /**
//     * @param $poolId
//     * @param $choiceId
//     * @return array
//     */
//    public function deleteChoice($poolId, $choiceId)
//    {
//        $poolChoice = PoolChoice::find()
//            ->where([
//                'pool' => $poolId,
//                'id' => $choiceId,
//            ])
//            ->asArray()
//            ->one();
//
//        return $poolChoice;
//    }
}