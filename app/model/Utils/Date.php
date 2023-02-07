<?php

namespace App\model\Utils;

class Date
{

    public static function getTodayDate(): string
    {
        return date('Y-m-d');
    }

    public static function getTodayTime(): string
    {
        return date('H:i:s');
    }

    public static function getTodayDateTime(): string
    {
        return date('Y-m-d H:i:s');
    }

    public static function getTodayDateTimeWithSeconds(): string
    {
        return date('Y-m-d H:i:s');
    }

    public static function getTodayDateTimeWithSecondsAndMilliseconds(): string
    {
        return date('Y-m-d H:i:s.u');
    }

    public static function getTodayDateTimeWithMilliseconds(): string
    {
        return date('Y-m-d H:i:s.u');
    }

    public static function getMonthName(int $month): string
    {
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];
        return $months[$month];
    }

    public static function TimeWithAMPM(string $time): string
    {
        $time = explode(':', $time);
        if ((int)$time[0] > 12) {
            $time[0] = (int)$time[0] - 12;
            return $time[0] . ':' . $time[1] . ' PM';
        } else {
            return $time[0] . ':' . $time[1] . ' AM';
        }
    }

    public static function GetProperDateTime(string $date): string
    {
        $dateTime = explode(' ', $date);
        $date=explode('-',$dateTime[0]);
        $Time=explode(':',$dateTime[1]);
        $properTime = self::TimeWithAMPM($Time[0] . ':' . $Time[1]);
        $month = self::getMonthName((int)$date[1]);
        return $date[2] . ' ' . $month . ' ' . $date[0] . ' ' . $properTime;
    }
    public static function GetProperDate(string $date): string
    {
        $dateTime = explode(' ', $date);
        $date=explode('-',$dateTime[0]);
        $month = self::getMonthName((int)$date[1]);
        return $date[2] . ' ' . $month . ' ' . $date[0];
    }

}