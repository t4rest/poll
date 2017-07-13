<?php

namespace backend\modules\pool\api;

use common\models\UploadAvatar;
use backend\modules\user\datatypes\UserStructure;
use yii;
use common\models\User as UserModel;
use yii\web\UploadedFile;

class Pool
{
    /**
     * @return array
     */
    public function getPools(): array
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
    }

    public function getPool($id): array
    {
        $userStructure = new UserStructure(Yii::$app->user->getIdentity());

        return $userStructure->serialize();
    }

}