<?php

namespace backend\modules\user\api;

use common\models\UploadAvatar;
use yii;
use common\models\User as UserModel;
use yii\web\UploadedFile;

class Users
{

    public function userList(array $filter = []): array
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
    }

    public function iFollow()
    {

    }

    public function myFollowers()
    {

    }

    public function follow($userId)
    {

    }

    public function unfollow($userId)
    {

    }
}