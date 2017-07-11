<?php
namespace common\exceptions;

class AuthorizationException extends ApisException
{
    const CODES_GROUP = 102;
    const CODES_BASE_CLASS = 'common\exceptions\codes\Access';

    /**
     * @return AuthorizationException
     * @throws \yii\base\Exception
     */
    public static function invalidToken() : AuthorizationException
    {
        return self::create(codes\Access::INVALID_TOKEN);
    }
} 