<?php
namespace common\exceptions;

use backend\api\exceptions\codes\Request;

class RequestException extends ApisException
{
    const CODES_GROUP = 5;
    const CODES_BASE_CLASS = 'backend\api\exceptions\codes\Request';

    /**
     * @param $param
     * @return RequestException
     * @throws \yii\base\Exception
     */
    public static function invalidParam($param) : RequestException
    {
        return static::create(Request::INVALID_PARAM, ['parameter' => $param]);
    }

    /**
     * @param null $message
     * @return RequestException
     * @throws \yii\base\Exception
     */
    public static function invalidRequest($message = null) : RequestException
    {
        $params = [];
        if (isset($message)) {
            $params['message'] = $message;
        }

        return self::create(Request::INVALID_REQUEST, $params);
    }
} 