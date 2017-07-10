<?php
namespace common\exceptions\codes;

class Request extends BaseCodes
{
    const INVALID_PARAMS = 5;
    const INVALID_PARAM = 501;
    const MISSING_PARAM = 50101;
    const INVALID_PARAM_TYPE = 50102;
    const INVALID_PARAM_VALUE = 50103;

    const UNSUPPORTED_REQUEST = 502;

    const INVALID_REQUEST = 503;

    const EMPTY_RESULT = 504;

    /**
     * @return array
     */
    protected function library() : array
    {
        return [
            self::INVALID_PARAMS => [
                'statusCode' => 400,
                'message' => 'Invalid request parameters'
            ],
            self::INVALID_PARAM => [
                'statusCode' => 400,
                'message' => 'Invalid parameter [{parameter}]'
            ],
            self::MISSING_PARAM => [
                'statusCode' => 400,
                'message' => 'Parameter {type}[{parameter}] was not received'
            ],
            self::INVALID_PARAM_TYPE => [
                'statusCode' => 400,
                'message' => 'Invalid parameter type'
            ],
            self::INVALID_PARAM_VALUE => [
                'statusCode' => 400,
                'message' => 'Invalid parameter value'
            ],
            self::UNSUPPORTED_REQUEST => [
                'statusCode' => 404,
                'message' => 'Unsupported {type} request'
            ],
            self::INVALID_REQUEST => [
                'statusCode' => 400,
                'message' => 'Invalid request. Request could not be executed'
            ]
        ];
    }
}
