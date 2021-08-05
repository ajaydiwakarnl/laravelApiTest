<?php


namespace App\Traits;


use Illuminate\Support\Str;

trait GenerateToken
{
    public  function createToken(int $l = 34, int $n = 62, int $s = 27): string
    {
        $numbers = '1234567890';
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $special = '!@#$%^&*()_+';

        return str_shuffle(substr(str_shuffle($numbers), 0, $n).substr(str_shuffle($letters), 0, $l).substr(str_shuffle($special), 0, $s));
    }
}
