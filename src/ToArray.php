<?php

namespace PhpDto;

trait ToArray
{
	use DtoSerialize;

	/**
	 * @param bool $toSnakeCase
	 * @param bool $includeNulls
	 * @param string $keyPrefix
	 * @return array
	 */
	public function toArray(
		bool $toSnakeCase = true,
		bool $includeNulls = false,
		string $keyPrefix = ''
	): array
	{
		$arr = self::castToArray($this);

		$result = [];

		foreach ($arr as $key => $value)
		{
			$key = $toSnakeCase ?
				ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $key)), '_') :
				lcfirst($key);

			$key = "{$keyPrefix}{$key}";

			if($value !== null || $includeNulls)
			{
				$result[$key] = $value;
			}
		}

		return $result;
	}
}
