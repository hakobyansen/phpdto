<?php

namespace PhpDto;

trait ToArray
{
	use DtoSerialize;

	/**
	 * @param bool $toSnakeCase
	 * @param bool $includeNulls
	 * @return array
	 */
	public function toArray(bool $toSnakeCase = true, bool $includeNulls = false): array
	{
		$arr = self::castToArray($this);

		if($toSnakeCase)
		{
			$result = [];

			foreach ($arr as $key => $value)
			{
				$key = ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $key)), '_');

				if($value !== null || $includeNulls)
				{
					$result[$key] = $value;
				}
			}

			return $result;
		}

		return $arr;
	}
}
