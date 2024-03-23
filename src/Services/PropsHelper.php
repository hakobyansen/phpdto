<?php

namespace PhpDto\Services;

use PhpDto\Types\Prop;

class PropsHelper
{
	/**
	 * @param array $props
	 * @return string[]
	 */
	public static function getPropNames(array $props): array
	{
		return array_map(
			callback: function(Prop $prop) {
			return $prop->getName();
		},
			array: $props
		);
	}
}
