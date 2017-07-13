<?php

namespace backend\modules\pool\api;

use common\models\UploadAvatar;
use backend\modules\user\datatypes\UserStructure;
use yii;
use common\models\User as UserModel;
use yii\web\UploadedFile;

class Feed
{

    public function myFeed(array $filter = [])
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
    }

    public function userVotes($poolId)
    {

    }
}