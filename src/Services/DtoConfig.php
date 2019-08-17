<?php

namespace PhpDto\Services;

class DtoConfig
{
	const PATTERNS_DIR = 'PHP_DTO_PATTERNS_DIR';
	const DTO_NAMESPACE = 'PHP_DTO_NAMESPACE';
	const CLASS_POSTFIX = 'PHP_DTO_CLASS_POSTFIX';
	const UNIT_TESTS_NAMESPACE = 'PHP_DTO_UNIT_TESTS_NAMESPACE';

	/**
	 * @param string|null $configFilePath
	 */
	public function setVariables( string $configFilePath = null ): void
	{
		if( !$configFilePath )
		{
			$configFilePath = getcwd().'/phpdto.json';
		}

		$obj = json_decode(file_get_contents($configFilePath) );

		foreach ( $obj->configs as $key => $value )
		{
			putenv($key.'='.$value);
		}
	}

	/**
	 * @param string $variable
	 * @return string|null
	 */
	public function getVariable( string $variable ): ?string
	{
		$value = null;

		if( getenv($variable) )
		{
			$value = getenv($variable);
		}

		return $value;
	}
}
