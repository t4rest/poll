<?php
namespace common\exceptions;

class AccessException extends ApisException
{
    const CODES_GROUP = 1;
    const CODES_BASE_CLASS = 'backend\api\exceptions\codes\Access';

    /**
     * @return AccessException
     * @throws \yii\base\Exception
     */
    public static function deniedPermission() : AccessException
    {
        return self::create(codes\Access::DENIED_PERMISSION);
    }
} 