<?php
namespace common\exceptions;

class DatabaseException extends ApisException{

    const CODES_GROUP=2;
    const CODES_BASE_CLASS='backend\api\exceptions\codes\Database';

    /**
     * @param null $message
     * @return DatabaseException
     * @throws \yii\base\Exception
     */
    public static function recordOperationFail($message=null) : DatabaseException
    {
        $params=[];
        if(isset($message)){
            $params['message']=$message;
        }

        return self::create(codes\Database::OPERATION_FAILED, $params);
    }

    /**
     * @param null $message
     * @return DatabaseException
     * @throws \yii\base\Exception
     */
    public static function recordNotFound($message=null) : DatabaseException
    {
        $params=[];
        if(isset($message)){
            $params['message']=$message;
        }

        return self::create(codes\Database::RECORD_NOT_FOUND, $params);
    }
} 