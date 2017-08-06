<?php
namespace common\exceptions\codes;

class Files extends BaseCodes
{
    const FILE_NOT_EXISTS = 304;
    const INCORRECT_FILETYPE = 305;
    const FILE_REQUIRED = 306;
    const IS_NOT_IMAGE = 307;
    const UNSUPPORTED_IMAGE_TYPE = 308;

    /**
     * @return array
     */
    protected function library() : array
    {
        return [
            self::FILE_NOT_EXISTS => [
                'statusCode' => 500,
                'message' => 'File [{filename}] is not exists'
            ],
            self::INCORRECT_FILETYPE => [
                'statusCode' => 500,
                'message' => 'Uploading file must be an image'
            ],
            self::FILE_REQUIRED => [
                'statusCode' => 500,
                'message' => 'Uploading file must be set necessarily'
            ],
            self::IS_NOT_IMAGE => [
                'statusCode' => 500,
                'message' => 'File is not image'
            ],
            self::UNSUPPORTED_IMAGE_TYPE => [
                'statusCode' => 500,
                'message' => 'Unsupported image type'
            ]
        ];
    }
}
