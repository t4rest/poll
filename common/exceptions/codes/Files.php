<?php
namespace common\exceptions\codes;

class Files extends BaseCodes
{
    const FILE_NOT_EXISTS = 304;
    const INCORRECT_FILETYPE = 305;
    const FILE_REQUIRED = 306;
    const IS_NOT_IMAGE = 307;

    const INVALID_FILESYSTEM_RESPONSE = 308;
    const UNSUPPORTED_IMAGE_TYPE = 309;

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
            self::INVALID_FILESYSTEM_RESPONSE => [
                'statusCode' => 500,
                'message' => 'GridFs driver response is incorrect'
            ],
            self::UNSUPPORTED_IMAGE_TYPE => [
                'statusCode' => 500,
                'message' => 'Unsupported image type'
            ]
        ];
    }
}
