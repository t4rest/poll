<?php
namespace common\exceptions\codes;

class Database extends BaseCodes
{
    const OPERATION_FAILED = 201;
    const RECORD_NOT_FOUND = 202;

    /**
     * @return array
     */
    protected function library() : array
    {
        return [
            self::OPERATION_FAILED => [
                'statusCode' => 500,
                'message' => 'Failed to perform operation on record'
            ],
            self::RECORD_NOT_FOUND => [
                'statusCode' => 500,
                'message' => 'Record you are trying to access does not exist'
            ]
        ];
    }
}
