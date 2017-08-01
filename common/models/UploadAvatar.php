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
    public $imageWebPath;

    public function rules()
    {
        return [
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->imagePath = 'avatar'
            . '/'
            . md5('user-avatar' . Yii::$app->user->id)
            . '/'
            . md5('user-avatar' . $this->image->baseName)
            . '.'
            . $this->image->extension;

        /**
         * @var \frostealth\yii2\aws\s3\Service $s3
         */
        $s3 = Yii::$app->get('s3');

        /**
         * @var $result \Aws\Result
         */
        $result = $s3->commands()
            ->upload($this->imagePath, $this->image->tempName)
            ->withContentType('image')
            ->execute();

        $data = $result->toArray();

        $this->imageWebPath = $data['ObjectURL'] ?? '';

        unlink($this->image->tempName);

        return isset($data['ObjectURL']);
    }

    /**
     *
     */
    public function deleteImage()
    {
        /**
         * @var \frostealth\yii2\aws\s3\Service $s3
         */
        $s3 = Yii::$app->get('s3');
        $s3->commands()->delete($this->imagePath)->execute();
    }
}