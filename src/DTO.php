<?php

namespace PhpDto;

abstract class Dto
{
	use DtoSerialize;

	/**
	 * @param array $items
	 * @param bool $shouldSerialize
	 * @return array
	 */
	public static function mapArray(array $items, bool $shouldSerialize = false): array
	{
		$results = [];

		foreach ($items as $item)
		{
			$results[] = new static($item);
		}

		if ($shouldSerialize)
		{
			$results = static::serializeArray($results);
		}

		return $results;
	}

	/**
	 * @param array $item
	 * @param bool $shouldSerialize
	 * @return Dto|\stdClass
	 */
	public static function mapSingle(array $item, bool $shouldSerialize = false)
	{
		$result = new static($item);

		if ($shouldSerialize)
		{
			$result = static::serializeSingle($result);
		}

		return $result;
	}
}
