<?php

namespace backend\modules\user\api;

use common\models\UploadAvatar;
use yii;
use common\models\User as UserModel;
use yii\web\UploadedFile;

class User
{
    /**
     * @return array
     */
    public function info(): array
    {
        $user = UserModel::findOne(Yii::$app->user->id);

        return $user->toArray();
    }

    /**
     * @return array
     */
    public function update()
    {
        $user = UserModel::findOne(Yii::$app->user->id);

        $user->setAttributes(Yii::$app->request->post());

        if (!$user->save()) {
            p($user->errors);
        }

        return $user->toArray();
    }

    /**
     * @return array
     */
    public function photo()
    {
        $model = new UploadAvatar();

        if (Yii::$app->request->isPost) {
            $model->image = UploadedFile::getInstanceByName('image');
            if (!$model->upload()) {
                p($model->errors);
            }
        }

        $user = UserModel::findOne(Yii::$app->user->id);

        $user->photo_url = $model->imagePath;
        $user->save(false);

        return $user->toArray();
    }
}