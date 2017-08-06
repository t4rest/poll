<?php

namespace backend\modules\user\api;

use common\models\UploadAvatar;
use yii;
use common\models\User as UserModel;
use yii\web\UploadedFile;
use common\exceptions;

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
     * @param array $data
     * @return array
     * @throws exceptions\RequestException
     */
    public function update(array $data): array
    {
        $user = UserModel::findOne(Yii::$app->user->id);
        $user->setAttributes($data);
        $user->setTime();

        $img = new UploadAvatar();
        $img->image = UploadedFile::getInstanceByName('image');


        if ($img->image && !$img->validate()) {
            throw exceptions\RequestException::invalidRequestError($img->getErrors());
        }

        if ($img->image && $img->upload()) {
            $user->photo_url = $img->imageWebPath;
        }

        if (!$user->save()) {

            if ($img->imagePath)  {
                $img->deleteImage();
            }

            throw exceptions\RequestException::invalidRequestError($user->getErrors());
        }

        return $user->toArray();
    }
}