<?php

declare(strict_types=1);

namespace PeibinLaravel\Codec;

class Base62
{
    public const CHARS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    public const BASE = 62;

    public static function encode(int $number): string
    {
        $chars = [];
        while ($number > 0) {
            $remain = $number % self::BASE;
            $chars[] = self::CHARS[$remain];
            $number = ($number - $remain) / self::BASE;
        }
        return implode('', array_reverse($chars));
    }

    public static function decode(string $data): int
    {
        return array_reduce(
            array_map(function ($character) {
                return strpos(self::CHARS, $character);
            }, str_split($data)),
            function ($result, $remain) {
                return $result * self::BASE + $remain;
            }
        );
    }
}
