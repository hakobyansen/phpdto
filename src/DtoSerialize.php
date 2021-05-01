<?php

namespace PhpDto;

trait DtoSerialize
{
    /**
     * @param array $dtoAr
     * @return array
     */
    public static function serializeArray( array $dtoAr ): array
    {
        $results = [];

        foreach ($dtoAr as $dto )
        {
            $arr = self::castToArray( $dto );

            $obj = (object)$arr;

            $results[] = $obj;
        }

        return $results;
    }

	/**
	 * @param Dto $dto
	 * @return \stdClass
	 */
	public static function serializeSingle( Dto $dto ): \stdClass
	{
		$arr = self::castToArray( $dto );

		return (object)$arr;
	}

	/**
	 * @param Dto $dto
	 * @return array
	 */
	public static function castToArray( Dto $dto ): array
	{
		$arr = [];

		$vars = get_object_vars($dto);

		foreach ( $vars as $key => $value )
		{
			$key = str_replace('_', '', $key);

			$arr[$key] = $value;
		}

		return $arr;
	}
}
