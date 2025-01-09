<?php

declare(strict_types=1);

namespace ZhandosProg\WriteSpelling\Dictionaries;

abstract class BaseDictionary
{
    protected static array $words = [];

    public static function get(string $key): mixed
    {
        return static::$words[$key] ?? null;
    }

    public static function all(): array
    {
        return static::$words;
    }
}