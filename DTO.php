<?php

namespace App\DTO;

abstract class DTO
{
    /**
     * @param array $items
     * @param bool $shouldSerialize
     * @return array
     */
    public static function mapArray(array $items, bool $shouldSerialize = false ): array
    {
        $results = [];

        foreach ($items as $item) {
            $results[] = new static($item);
        }

        if ($shouldSerialize) {
            $results = static::serialize($results);
        }

        return $results;
    }

    /**
     * @param array $item
     * @param bool $shouldSerialize
     * @return DTO
     */
    public static function mapSingle(array $item, bool $shouldSerialize = false): DTO
    {
        // todo: care about serialization
        return new static($item);
    }
}