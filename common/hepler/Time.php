<?php
namespace common\helper;

class Time
{
    public static function getCurrentTime()
    {
        return (new \DateTime())->format('Y-m-d H:i:s');
    }

}