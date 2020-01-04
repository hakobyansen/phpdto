<?php

namespace PhpDto\Services;

use PhpDto\Dto;
use PhpDto\DtoSerialize;

class DtoBuilder
{
	/**
	 * @param array $configs
	 * @return string
	 */
	public function getNamespace( array $configs ): string
	{
		$namespace = getenv( 'PHP_DTO_NAMESPACE' );

		if (isset($configs['namespace_postfix']))
		{
			$namespace .= $configs['namespace_postfix'];
		}

		return $namespace;
	}

	/**
	 * @param array $dtoConfigs
	 * @return string
	 */
	public function getClassName( array $dtoConfigs ): string
	{
		$classPrefix = ucfirst( $dtoConfigs['class'] );

		return $classPrefix.getenv( 'PHP_DTO_CLASS_POSTFIX' );
	}

	/**
	 * @return array
	 */
	public function getModules(): array
	{
		return [];
	}

	public function getTraits(): array
	{
		return [
			'\\'.DtoSerialize::class
		];
	}

	/**
	 * @param array $configs
	 * @param string $visibility
	 * @return array
	 */
	public function getProps( array $configs, string $visibility = 'private' ): array
	{
		$props = [];

		foreach ($configs['rules'] as $key => $value)
		{
			$type = '';

			if( strpos($value, 'nullable') !== false )
			{
				$type = '?';
				$value = str_replace('nullable|', '', $value);
				$value = str_replace('|nullable', '', $value);
			}

			$type .= $value;

			$props[] = "{$visibility} {$type}" . ' $_' . "{$key};";
		}

		return $props;
	}

	/**
	 * @param array $configs
	 * @return string
	 */
	public function getConstructorParam( array $configs ): string
	{
		return $configs['class'];
	}

	/**
	 * @param array $configs
	 * @return array
	 */
    public function getConstructorProps( array $configs ): array
    {
        $keys = [];

        foreach ( $configs['rules'] as $key => $value )
        {
            $keys[] = $key;
        }

        return $keys;
    }

    /**
     * @param array $configs
     * @param string $visibility
     * @return array
     */
    public function getMethods( array $configs, string $visibility = 'public' ): array
    {
        $methods = [];

        foreach ($configs['rules'] as $key => $value)
        {
            $rules = explode('|', $value);

            $returnType = '';

            $returnType .= in_array( 'nullable', $rules ) ? '?' : '';
            $returnType .= in_array( 'int', $rules ) ? 'int' : '';
            $returnType .= in_array( 'float', $rules ) ? 'float' : '';
            $returnType .= in_array( 'string', $rules ) ? 'string' : '';
            $returnType .= in_array( 'bool', $rules ) ? 'bool' : '';
            $returnType .= in_array( 'array', $rules ) ? 'array' : '';

            $declaration = 'function get'.ucfirst($key).'(): '.$returnType;

            $method['visibility']  = $visibility;
            $method['declaration'] = $declaration;
            $method['body']        = 'return $this->_'.$key.';';

            $methods[] = $method;
        }

        return $methods;
    }
}
