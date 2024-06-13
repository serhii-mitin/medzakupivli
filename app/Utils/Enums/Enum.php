<?php

namespace App\Utils\Enums;

use Illuminate\Support\Collection;
use ReflectionClass;

class Enum
{
    /**
     * @var array<string, Collection>
     */
    private static $cachedList = [];

    /**
     * Get enum collection.
     *
     * @return Collection
     */
    public static function list(): Collection
    {
        $class = static::class;

        if (! (static::$cachedList[$class] ?? false)) {
            try {
                $reflection = new ReflectionClass($class);
            } catch (Exception $exception) {
                $reflection = null;
            }

            static::$cachedList[$class] = collect($reflection->getConstants());
        }

        return static::$cachedList[$class];
    }

    /**
     * Get value collection.
     *
     * @return Collection
     */
    public static function values(): Collection
    {
        return self::list()->values();
    }

    /**
     * Get keys collection.
     *
     * @return Collection
     */
    public static function keys(): Collection
    {
        return self::list()->keys();
    }

    /**
     * Check is exist value.
     *
     * @param $value
     *
     * @return bool
     */
    public static function exist($value): bool
    {
        return self::list()->contains($value);
    }

    /**
     * Get key by value.
     *
     * @param $value
     *
     * @return string
     */
    public static function getKey($value): string
    {
        return strtolower((string) self::list()->search($value));
    }

    /**
     * Get value by key.
     *
     * @param $key
     *
     * @return mixed
     */
    public static function getValue($key)
    {
        return self::list()->get(strtoupper($key));
    }

    /**
     * Value labels.
     * Overwrite this function for getting labels.
     *
     * @return array
     */
    public static function labels(): array
    {
        return [];
    }

    /**
     * Label of value.
     *
     * @param string|int $value
     *
     * @return mixed
     */
    public static function label($value)
    {
        return static::labels()[$value] ?? $value;
    }

    /**
     * Values to string.
     *
     * @param string $separator
     *
     * @return string
     */
    public static function toString(string $separator = ','): string
    {
        return self::values()->implode($separator);
    }
}

