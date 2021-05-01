<?php

namespace PhpDto;

trait ToArray
{
	use DtoSerialize;

	/**
	 * @param bool $toSnakeCase
	 * @return array
	 */
	public function toArray($toSnakeCase = true): array
	{
		if($toSnakeCase)
		{
			$result = [];

			foreach (self::castToArray($this) as $key => $value)
			{
				$key = ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $key)), '_');

				$result[$key] = $value;
			}

			return $result;
		}

		return self::castToArray($this);
	}
}
