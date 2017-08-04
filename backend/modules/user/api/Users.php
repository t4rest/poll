<?php

namespace backend\modules\user\api;

use common\models\User as UserModel;
use common\models\UserFriend;
use Yii;
use common\exceptions;
use common\pagination;

class Users
{
    /**
     * @param array $search
     * @param array $filter
     * @param pagination\OffsetBased $pagination
     * @return array
     */
    public function userList(array $search = [], array $filter = [], pagination\OffsetBased $pagination): array
    {
        $usersModel = UserModel::find()
            ->with('friends')
            ->select(["id", "username", "first_name", "last_name", "email", "photo_url", "country"])
            ->where(['status' => UserModel::STATUS_ACTIVE]);

        if (isset($search['username'])) {
            $usersModel->andWhere(['like', 'username', $search['username']]);
        }

        $users = $usersModel
            ->limit($pagination->getLimit() + 1)// in this way we check if we have next paginated page
            ->offset($pagination->getOffset())
            ->asArray()
            ->all();

        if (count($users) > $pagination->getLimit()) {

            /**
             * remove extra last element from array if count more than limit
             * to avoid extra query to db
             */
            $pagination->setNext(true);
            array_pop($users);
        }

        return $users;
    }

    /**
     * @param array $search
     * @param array $filter
     * @param pagination\OffsetBased $pagination
     * @return array
     */
    public function iFollow(array $search = [], array $filter = [], pagination\OffsetBased $pagination): array
    {
        $friendsIds = UserFriend::find()
            ->select(['friend_id'])
            ->where(['user_id' => Yii::$app->user->id])
            ->indexBy('friend_id')
            ->limit($pagination->getLimit() + 1)// in this way we check if we have next paginated page
            ->offset($pagination->getOffset())
            ->asArray()
            ->all();

        if (count($friendsIds) > $pagination->getLimit()) {

            /**
             * remove extra last element from array if count more than limit
             * to avoid extra query to db
             */
            $pagination->setNext(true);
            array_pop($friendsIds);
        }

        $users = UserModel::find()
            ->select(["id", "username", "first_name", "last_name", "email", "photo_url", "country"])
            ->where(['id' => array_keys($friendsIds)])
            ->asArray()
            ->all();

        return $users;
    }

    /**
     * @param array $search
     * @param array $filter
     * @param pagination\OffsetBased $pagination
     * @return array|\yii\db\ActiveRecord[]
     */
    public function myFollowers(array $search = [], array $filter = [], pagination\OffsetBased $pagination): array
    {
        $friendsIds = UserFriend::find()
            ->select(['user_id'])
            ->where(['friend_id' => Yii::$app->user->id])
            ->indexBy('user_id')
            ->limit($pagination->getLimit() + 1)// in this way we check if we have next paginated page
            ->offset($pagination->getOffset())
            ->asArray()
            ->all();


        if (count($friendsIds) > $pagination->getLimit()) {

            /**
             * remove extra last element from array if count more than limit
             * to avoid extra query to db
             */
            $pagination->setNext(true);
            array_pop($friendsIds);
        }

        $users = UserModel::find()
            ->select(["id", "username", "first_name", "last_name", "email", "photo_url", "country"])
            ->where(['id' => array_keys($friendsIds)])
            ->asArray()
            ->all();

        return $users;
    }

    /**
     * @param $userId
     * @return array
     * @throws exceptions\RequestException
     */
    public function follow($userId): array
    {
        $friend = UserFriend::find()
            ->where(['friend_id' => $userId, 'user_id' => Yii::$app->user->id])
            ->asArray()
            ->one();

        if ($friend) {
            return $friend;
        }

        $user = UserModel::find()
//            ->select(["id", "username", "first_name", "last_name", "email", "photo_url", "country"])
            ->select(["id"])
            ->where(['id' => $userId])
            ->asArray()
            ->one();

        if (!$user) {
            throw exceptions\RequestException::invalidRequest('User does not exists');
        }

        $friend = new UserFriend();
        $friend->user_id = Yii::$app->user->id;
        $friend->friend_id = $userId;
        $friend->setTime();
        $friend->save();

        return $friend->toArray();
    }

    /**
     * @param $userId
     * @return bool
     */
    public function unfollow($userId): bool
    {
        $friend = UserFriend::find()
            ->where(['friend_id' => $userId, 'user_id' => Yii::$app->user->id])
            ->one();

        if ($friend) {
            $friend->delete();
        }

        return true;
    }
}