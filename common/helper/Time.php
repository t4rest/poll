<?php
namespace common\helper;

class Time
{
    public static function getCurrentTime()
    {
        return (new \DateTime())
            ->setTimezone(new \DateTimeZone("UTC"))
            ->format('Y-m-d H:i:s');
    }

}