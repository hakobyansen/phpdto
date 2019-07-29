<?php

namespace PhpDto;

trait DTOSerialize
{
    /**
     * @param array $dtos
     * @return array
     */
    public static function serializeArray( array $dtos ): array
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

	public function serializeSingle( DTO $dto )
	{
		$arr = [];

		foreach ( (array)get_object_vars($dto) as $key => $value )
		{
	 		$key = str_replace('_', '', $key);

			$arr[$key] = $value;
		}

		$obj = (object)$arr;

		return $obj;
	}
}
