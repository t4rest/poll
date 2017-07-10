<?php
namespace common\exceptions;

class FilesException extends ApisException
{
    const CODES_GROUP = 3;
    const CODES_BASE_CLASS = 'backend\api\exceptions\codes\Files';

    /**
     * @return FilesException
     */
    public static function incorrectFileType() : FilesException
    {
        return static::create(codes\Files::INCORRECT_FILETYPE);
    }

    /**
     * @return FilesException
     * @throws \yii\base\Exception
     */
    public static function fileRequired() : FilesException
    {
        return self::create(codes\Files::FILE_REQUIRED);
    }
} 