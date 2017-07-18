<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\UploadedFile;

class UploadAvatar extends Model
{
    /**
     * @var UploadedFile
     */
    public $image;
    public $imagePath;

    public function rules()
    {
        return [
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload(int $userId)
    {
        $path = '/web/avatar/' . md5('user-avatar' . $userId) . '.' . $this->image->extension;
        $imagePath = Yii::getAlias('@frontend') . $path;
        $this->imagePath = Url::base(true) . $path;

        if ($this->validate()) {
            $this->image->saveAs($imagePath);
            return true;
        } else {
            return false;
        }
    }
}