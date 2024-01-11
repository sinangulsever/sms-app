<?php

namespace App\Enums;


enum Enums
{

    public static function smsStatus($status): string
    {
        return match ($status) {
            0 => 'Pending',
            1 => 'Completed',
            2 => 'Canceled',
            default => 'Pending',
        };
    }

    public static function smsDetailStatus($status): string
    {
        return match ($status) {
            0 => 'Pending',
            1 => 'Success',
            2 => 'Failed',
            default => 'Pending',
        };
    }

}
