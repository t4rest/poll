<?php
namespace common\exceptions;

use common\exceptions\codes\Request;

class RequestException extends ApisException
{
    const CODES_GROUP = 5;
    const CODES_BASE_CLASS = 'common\exceptions\codes\Request';

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

    /**
     * @param array $errors
     * @return ApisException|static
     */
    public static function invalidRequestError(array $errors = [])
    {
        $params = [];
        if (!empty($errors)) {
            $params['message'] =  current($errors)[0];
        }

        return self::create(Request::INVALID_REQUEST, $params);
    }
} 