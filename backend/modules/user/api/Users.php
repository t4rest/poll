<?php

namespace backend\modules\user\api;

use common\models\User as UserModel;

class Users
{

    public function userList(array $filter = []): array
    {
        $users = UserModel::find()
            ->asArray()
            ->all();

        return $users;
    }

    public function iFollow()
    {
        $users = UserModel::find()
            ->asArray()
            ->all();

        return $users;
    }

    public function myFollowers()
    {
        $users = UserModel::find()
            ->asArray()
            ->all();

        return $users;
    }

    public function follow($userId)
    {
        $users = UserModel::find()
            ->asArray()
            ->all();

        return $users;
    }

    public function unfollow($userId)
    {
        $users = UserModel::find()
            ->asArray()
            ->all();

        return $users;
    }
}