<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadPoolPhoto extends Model
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

    public function upload()
    {
        $this->imagePath = Yii::getAlias('@frontend') . '/web/pool/' .
            md5($this->image->baseName . uniqid()) .
            '.' . $this->image->extension;

        if ($this->validate()) {
            $this->image->saveAs($this->imagePath);
            return true;
        } else {
            return false;
        }
    }
}