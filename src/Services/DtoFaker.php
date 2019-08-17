<?php

namespace PhpDto\Services;

class DtoFaker
{
	/**
	 * DtoFaker constructor.
	 */
	public function __construct()
	{
		(new DtoConfig())->setVariables();
	}

	/**
	 * @param string $patternPath
	 * @param int $length
	 * @return array
	 * @throws \Exception
	 */
	public function fakeArrayFromPattern( string $patternPath, int $length = 10 ): array
	{
		$data = [];

		$patternPath = getenv('PHP_DTO_PATTERNS_DIR').'/'.$patternPath;

		if( file_exists($patternPath) )
		{
			$obj = json_decode( file_get_contents($patternPath) );
		}

		for( $i = 0; $i < $length; $i++ )
		{
			$data[] = self::getItem( $obj );
		}

		return $data;
	}

	/**
	 * @param string $patternPath
	 * @return array
	 * @throws \Exception
	 */
	public function fakeSingleFromPattern( string $patternPath ): array
	{
		$data = [];

		$patternPath = getenv('PHP_DTO_PATTERNS_DIR').'/'.$patternPath;

		if( file_exists($patternPath) )
		{
			$obj = json_decode( file_get_contents($patternPath) );
			$data = self::getItem( $obj );
		}

		return $data;
	}

	/**
	 * @param \stdClass $obj
	 * @return array
	 * @throws \Exception
	 */
	public static function getItem( \stdClass $obj ): array
	{
		$item = [];

		foreach ( $obj->rules as $key => $value )
		{
			$rules = explode('|', $value);

			$generatedValue = self::generateValue( $rules );

			$item[$key] = $generatedValue;
		}

		return $item;
	}

	/**
	 * @param array $rules
	 * @return mixed
	 * @throws \Exception
	 */
	public static function generateValue( array $rules )
	{
		$value = null;

		if( in_array( 'string', $rules ) )
		{
			$value = self::randomString();
		}
		elseif ( in_array( 'int', $rules ) )
		{
			$value = random_int(100, 999);
		}
		elseif( in_array( 'bool', $rules ) )
		{
			$value = random_int(1, 2) === 1;
		}
		elseif( in_array( 'float', $rules ) )
		{
			$res = random_int(10, 100) / random_int(1, 10);

			$value = (float)$res;
		}

		return $value;
	}

	/**
	 * Thanks to https://github.com/laravel/framework/blob/5.8/src/Illuminate/Support/Str.php
	 * @param $length
	 * @return string
	 * @throws \Exception
	 */
	public static function randomString( $length = 20 )
	{
		$string = '';

		while ( ($len = strlen($string)) < $length )
		{
			$size = $length - $len;

			$bytes = random_bytes($size);

			$string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
		}

		return $string;
	}
}
