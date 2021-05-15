<?php

namespace PhpDto\Services;

use PhpDto\Dto;

class DtoFaker
{
	/**
	 * @param string $dtoClassName
	 * @param int $length
	 * @return array
	 * @throws \ReflectionException
	 */
	public static function fakeArray( string $dtoClassName, int $length = 10 ): array
	{
		$data = [];

		for( $i = 0; $i< $length; $i++ )
		{
			$data[] = self::fakeSingle( $dtoClassName );
		}

		return $data;
	}

	/**
	 * @param string $dtoClassName
	 * @return array
	 * @throws \ReflectionException
	 * @throws \Exception
	 */
	public static function fakeSingle( string $dtoClassName ): array
	{
		$props = [];

		$reflectionClass = new \ReflectionClass( $dtoClassName );
		$reflectionProperties = $reflectionClass->getProperties();

		foreach ($reflectionProperties as $property)
		{
			$propertyName =  $property->getName();

			if( $propertyName[0] === '_' )
			{
				$propertyName = substr( $propertyName, 1 );
			}

			$methodName = 'get'.ucfirst($propertyName);

			$reflectionMethod = $reflectionClass->getMethod($methodName);

			if( $reflectionMethod->hasReturnType() )
			{
				$returnType = $reflectionMethod->getReturnType();

				$prop = $returnType->getName();

				if( $returnType->allowsNull() )
				{
					$prop .= '|nullable';
				}
			}
			else
			{
				$prop = 'string';
			}

			// Converting camelCase to snake_case
			$propertyName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $propertyName));
			$props[$propertyName] = $prop;
		}

		return self::fakeItem( $props );
	}

	/**
	 * @param string $patternPath
	 * @param int $length
	 * @return array
	 * @throws \Exception
	 */
	public static function fakeArrayFromPattern( string $patternPath, int $length = 10 ): array
	{
		$data = [];

		if( file_exists($patternPath) )
		{
			$obj = json_decode( file_get_contents($patternPath) );
			$props = (array)$obj->props;

			for( $i = 0; $i < $length; $i++ )
			{
				$data[] = self::fakeItem( $props );
			}
		}

		return $data;
	}

	/**
	 * @param string $patternPath
	 * @return array
	 * @throws \Exception
	 */
	public static function fakeSingleFromPattern( string $patternPath ): array
	{
		$data = [];

		if( file_exists($patternPath) )
		{
			$obj = json_decode( file_get_contents($patternPath) );
			$props = (array)$obj->props;
			$data = self::fakeItem( $props);
		}

		return $data;
	}

	/**
	 * @param array $props
	 * @return array
	 * @throws \Exception
	 */
	public static function fakeItem(array $props ): array
	{
		$item = [];

		foreach ( $props as $key => $value )
		{
			$props = explode('|', $value);

			$generatedValue = self::generateValue( $props );

			$item[$key] = $generatedValue;
		}

		return $item;
	}

	/**
	 * @param array $props
	 * @return mixed
	 * @throws \Exception
	 */
	public static function generateValue( array $props )
	{
		$value = null;

		if( in_array( 'string', $props ) )
		{
			$value = self::randomString();
		}
		elseif ( in_array( 'int', $props ) )
		{
			$value = random_int(100, 999);
		}
		elseif( in_array( 'bool', $props ) )
		{
			$value = random_int(1, 2) === 1;
		}
		elseif( in_array( 'float', $props ) )
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
	public static function randomString( $length = 20 ): string
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
