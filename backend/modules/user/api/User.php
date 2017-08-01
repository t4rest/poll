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
        $user->setTime();

        $model = new UploadAvatar();
        $model->image = UploadedFile::getInstanceByName('image');
        if ($model->image && $model->upload()) {
            $user->photo_url = $model->imageWebPath;
        }

        if (!$user->save()) {
            $model->deleteImage();
            p($user->errors);
        }

        return $user->toArray();
    }
}