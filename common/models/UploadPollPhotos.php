<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadPollPhotos extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $images;

    /**
     * @var array
     */
    public $imagesPath = [];
    public $imagesWebPath = [];

    public function rules()
    {
        return [
            [['images'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function upload()
    {
        if (!$this->validate()) {
            return false;
        }

        foreach ($this->images as $file) {

            $path = 'poll'
                . '/'
                . md5(Yii::$app->user->id)
                . '/'
                . md5('poll' . $file->baseName . uniqid())
                . '.'
                . $file->extension;

            $this->imagesPath[] = $path;

            /**
             * @var \frostealth\yii2\aws\s3\Service $s3
             */
            $s3 = Yii::$app->get('s3');

            /**
             * @var $result \Aws\Result
             */
            $result = $s3->commands()
                ->upload($path, $file->tempName)
                ->withContentType('image')
                ->execute();

            $data = $result->toArray();



            unlink($file->tempName);

            if (!isset($data['ObjectURL'])) {
                $this->deleteImages();
                return false;
            }

            $this->imagesWebPath[] = $data['ObjectURL'];
        }

        return true;
    }

    /**
     *
     */
    public function deleteImages()
    {
        /**
         * @var \frostealth\yii2\aws\s3\Service $s3
         */
        $s3 = Yii::$app->get('s3');
        foreach ($this->imagesPath as $file) {
            $s3->commands()->delete($file)->execute();
        }
    }
}