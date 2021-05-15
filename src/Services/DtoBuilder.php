<?php

namespace PhpDto\Services;

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

	/**
	 * @return string[]
	 */
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

		foreach ($configs['props'] as $key => $value)
		{
			$type = '';

			if( strpos($value, 'nullable') !== false )
			{
				$type = '?';
				$value = str_replace('nullable|', '', $value);
				$value = str_replace('|nullable', '', $value);
			}

			$type .= $value;

			$key = $this->convertPropToSnakeCase($key);

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

        foreach ( $configs['props'] as $key => $value )
        {
        		$key = $this->convertPropToSnakeCase($key);

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

        foreach ($configs['props'] as $key => $value)
        {
            $props = explode('|', $value);

            $returnType = '';

            $returnType .= in_array( 'nullable', $props ) ? '?' : '';
            $returnType .= in_array( 'int', $props ) ? 'int' : '';
            $returnType .= in_array( 'float', $props ) ? 'float' : '';
            $returnType .= in_array( 'string', $props ) ? 'string' : '';
            $returnType .= in_array( 'bool', $props ) ? 'bool' : '';
            $returnType .= in_array( 'array', $props ) ? 'array' : '';

			  if (strpos($key, '_') !== false)
			  {
				  $key = join('', array_map('ucfirst', explode('_', $key)));
			  }

            $declaration = 'function get'.ucfirst($key).'(): '.$returnType;

            $method['visibility']  = $visibility;
            $method['declaration'] = $declaration;
            $method['body']        = 'return $this->_'.lcfirst($key).';';

            $methods[] = $method;
        }

        return $methods;
    }

	/**
	 * @param string $prop
	 * @return string
	 */
	public function convertPropToSnakeCase(string $prop): string
	{
		if (strlen($prop) > 0 && strpos($prop, '_') !== false)
		{
			$exploded = explode('_', $prop);

			if ($prop[0] != '_')
			{
				$prop = $exploded[0];
				unset($exploded[0]);
			}
			else
			{
				$prop = $prop[0] . $exploded[1];
				unset($exploded[1]);
			}

			$prop .= join('', array_map('ucfirst', array_merge($exploded)));
		}

		return $prop;
	}
}
