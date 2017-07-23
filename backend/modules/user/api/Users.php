<?php

namespace backend\modules\user\api;

use common\models\User as UserModel;
use common\models\UserFriend;
use Yii;
use common\exceptions;

class Users
{
    public function userList(): array
    {
        $search = Yii::$app->request->get('search');
        $users = UserModel::find()
            ->with('friends')
            ->select(["id", "username", "first_name", "last_name", "email", "photo_url", "country"])
            ->where(['status' => UserModel::STATUS_ACTIVE])
            ->asArray();

        if (!empty($search)) {
            $users->andWhere(['like', 'username', $search]);
        }

        return $users->all();
    }

    public function iFollow()
    {
        $users = UserFriend::find()
            ->with('friend')
            ->where(['user_id' => Yii::$app->user->id])
            ->asArray()
            ->all();

        return $users;
    }

    public function myFollowers()
    {
        $users = UserFriend::find()
            ->with('user')
            ->where(['friend_id' => Yii::$app->user->id])
            ->asArray()
            ->all();

        return $users;
    }

    public function follow($userId)
    {
        $friend = UserFriend::find()
            ->where(['friend_id' => $userId, 'user_id' => Yii::$app->user->id])
            ->asArray()
            ->one();

        if ($friend) {
            return $friend;
        }

        $user = UserModel::find()
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

    public function unfollow($userId)
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