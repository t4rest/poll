<?php

namespace backend\modules\pool\api;

use common\exceptions\DatabaseException;
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

        try {

            $pool = new PoolModel();
            $pool->setAttributes(Yii::$app->request->post());
            $pool->user_id = Yii::$app->user->id;
            $pool->setTime();

            $model = new UploadPoolPhoto();
            $model->image = UploadedFile::getInstanceByName('image');
            if ($model->image && $model->upload($pool->id)) {
                $pool->photo_url = $model->imagePath;
            }

            if (!$pool->save()) {
                p($pool->errors);
                throw DatabaseException::recordOperationFail();
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
     * @throws DatabaseException
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
     * @return array
     * @throws DatabaseException
     */
    public function updatePool($id): array
    {
        $pool = PoolModel::findOne($id);


        $pool->setAttributes(Yii::$app->request->getBodyParams());

        $model = new UploadPoolPhoto();
        $model->image = UploadedFile::getInstanceByName('image');
        if ($model->image && $model->upload(Yii::$app->user->id)) {
            $pool->photo_url = $model->imagePath;
        }

        if (!$pool->save()) {
            throw DatabaseException::recordOperationFail();
        }

        return $pool->toArray();
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

    /**
     * @param $poolId
     * @return array
     */
    public function getChoices($poolId)
    {
        $poolChoices = PoolChoice::find()
            ->where(['pool' => $poolId])
            ->asArray()
            ->all();

        return $poolChoices;
    }

    /**
     * @param $poolId
     * @return array
     */
    public function addChoice($poolId)
    {
        $poolChoice = PoolChoice::find()
            ->where(['pool' => $poolId])
            ->asArray()
            ->one();

        return $poolChoice;
    }

    /**
     * @param $poolId
     * @param $choiceId
     * @return array
     */
    public function updateChoice($poolId, $choiceId)
    {
        $poolChoice = PoolChoice::find()
            ->where([
                'pool' => $poolId,
                'id' => $choiceId,
            ])
            ->asArray()
            ->one();

        return $poolChoice;
    }

    /**
     * @param $poolId
     * @param $choiceId
     * @return array
     */
    public function deleteChoice($poolId, $choiceId)
    {
        $poolChoice = PoolChoice::find()
            ->where([
                'pool' => $poolId,
                'id' => $choiceId,
            ])
            ->asArray()
            ->one();

        return $poolChoice;
    }
}