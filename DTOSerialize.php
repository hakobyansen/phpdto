<?php

namespace App\DTO;

trait DTOSerialize
{
    /**
     * @param array $dtos
     * @return array
     */
    public static function serialize( array $dtos ): array
    {
        $results = [];

        foreach ( $dtos as $dto )
        {
            $arr = [];

            foreach ((array)get_object_vars($dto) as $key => $value )
            {
                $key = str_replace('_', '', $key);

                $arr[$key] = $value;
            }

            $obj = (object)$arr;

            $results[] = $obj;
        }

        return $results;
    }
}
