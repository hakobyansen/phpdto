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
		return self::castToArray(
			dto: $this,
			toSnakeCase: $toSnakeCase,
			includeNulls: $includeNulls,
			keyPrefix: $keyPrefix
		);
	}
}
