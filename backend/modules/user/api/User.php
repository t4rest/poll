<?php

namespace backend\modules\user\api;

use backend\modules\user\datatypes\UserStructure;
use yii;


class User
{

    /**
     * @return array
     */
    public function info(): array
    {
        $user = new UserStructure(
            Yii::$app->user->getIdentity()
        );

        return $user->serialize();
    }
}