<?php
namespace common\exceptions\codes;

class Access extends BaseCodes
{
    const DENIED_PERMISSION = 101;

    const AUTHORIZATION_ERROR = 102;
    const WRONG_USERNAME_OR_PASSWORD = 10201;
    const NOT_CONFIRMED_EMAIL = 10202;
    const DISABLED_ACCOUNT = 10203;
    const TOKEN_NOT_FOUND = 10204;
    const INVALID_TOKEN = 10205;
    const DISABLED_MODULE = 103;

    /**
     * @return array
     */
    protected function library() : array
    {
        return [
            self::DENIED_PERMISSION => [
                'statusCode' => 403,
                'message' => 'You do not have permission to access this resource'
            ],
            self::AUTHORIZATION_ERROR => [
                'statusCode' => 401,
                'message' => 'Undefined authorization error'
            ],
            self::WRONG_USERNAME_OR_PASSWORD => [
                'statusCode' => 401,
                'message' => 'Wrong username or password'
            ],
            self::NOT_CONFIRMED_EMAIL => [
                'statusCode' => 401,
                'message' => 'Email is not confirmed'
            ],
            self::DISABLED_ACCOUNT => [
                'statusCode' => 401,
                'message' => 'Account is disabled'
            ],
            self::INVALID_TOKEN => [
                'statusCode' => 401,
                'message' => 'Invalid token'
            ]
        ];
    }
}
