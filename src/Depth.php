<?php

namespace Gonzalezoda\JsonToCode;

class Depth
{
    protected static int $depth = 0;

    public static function inc()
    {
        self::$depth++;
    }

    public static function dec()
    {
        self::$depth--;
    }

    public static function space(): string
    {
        return str_repeat(' ', self::$depth * 4);
    }
}