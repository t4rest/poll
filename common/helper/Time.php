<?php
namespace common\helper;

class Time
{
    /**
     * @return string
     */
    public static function getCurrentTime(): string
    {
        return (new \DateTime())
            ->setTimezone(new \DateTimeZone("UTC"))
            ->format('Y-m-d H:i:s');
    }

    /**
     * @return int
     */
    public static function getCurrentUnixTime(): int
    {
        return (new \DateTime())
            ->setTimezone(new \DateTimeZone("UTC"))
            ->getTimestamp();
    }

}