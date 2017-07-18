<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
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

    public function upload($poolId)
    {
        $path = '/web/pool/' . md5('pool' . $poolId) . '.' . $this->image->extension;

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