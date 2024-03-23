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
	 * @param array $arr
	 * @param bool $toSnakeCase
	 * @param bool $includeNulls
	 * @param string $keyPrefix
	 * @return array
	 */
	public static function castToArray(
		Dto $dto,
		array $arr = [],
		bool $toSnakeCase = false,
		bool $includeNulls = false,
		string $keyPrefix = ''
	): array
	{
		$vars = $dto->getObjectVars();

		foreach ( $vars as $key => $value )
		{
			$key = str_replace('_', '', $key);
			$temp = [];

			$key = $toSnakeCase ?
				ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $key)), '_') :
				lcfirst($key);

			$key = "{$keyPrefix}{$key}";

			if($value instanceof Dto)
			{
				$temp = self::castToArray(
					dto: $value,
					arr: $temp,
					toSnakeCase: $toSnakeCase,
					includeNulls: $includeNulls,
					keyPrefix: $keyPrefix,
				);
				$arr[$key] = $temp;
			}
			else if(!is_null($value) || $includeNulls)
			{
				$arr[$key] = $value;
			}
		}

		return $arr;
	}

	/**
	 * @return array
	 */
	public function getObjectVars(): array
	{
		return get_object_vars($this);
	}
}
