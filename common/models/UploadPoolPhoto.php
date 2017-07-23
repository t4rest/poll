<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\UploadedFile;

class UploadPoolPhoto extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $images;

    /**
     * @var array
     */
    public $imagesPath = [];
    public $imagesRealPath = [];

    public function rules()
    {
        return [
            [['images'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {

            $i = 1;
            foreach ($this->images as $file) {
                $path = '/web/pool/' . md5('pool' . $file->baseName . uniqid()) . '.' . $file->extension;

                $imagePath = Yii::getAlias('@frontend') . $path;


                $this->imagesRealPath[$i] = $imagePath;
                $i++;

                $this->imagesPath[] = Url::base(true) . $path;

                $file->saveAs($imagePath);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     */
    public function deleteImages()
    {
        foreach ($this->imagesRealPath as $file) {
            if (file_exists($file)) unlink($file);
        }
    }
}