<?php

namespace PhpDto\Services;

use PhpDto\DtoSerialize;
use PhpDto\Enum\Types;

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
	 * @param array $configs
	 * @return string
	 */
	public function getClassName( array $configs ): string
	{
		$classPrefix = ucfirst( $configs['class'] );

		return $classPrefix.getenv( 'PHP_DTO_CLASS_POSTFIX' );
	}

	/**
	 * @param array $configs
	 * @return array
	 */
	public function getModules( array $configs ): array
	{
		$defaultModules = [
			'PhpDto\Dto',
			'PhpDto\DtoSerialize'
		];

		return $this->mergeModulesFromProps(
			modules: $configs['modules'] ?? $defaultModules,
			props: $configs['props'] ?? []
		);
	}

	/**
	 * @return string[]
	 */
	public function getTraits(): array
	{
		return [
			'DtoSerialize'
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
			$key = $this->convertPropToSnakeCase($key);

			$value = $this->getLastSegmentFromPath($value);

			$props[] = "{$visibility} {$value}" . ' $_' . "{$key};";
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
			 if (str_contains($key, '_'))
			 {
				 $key = join('', array_map('ucfirst', explode('_', $key)));
			 }

			 $returnType = $this->getReturnTypeFromValue($value);

			 $declaration = 'function get' . ucfirst($key) . '(): ' . $returnType;

			 $method['visibility'] = $visibility;
			 $method['declaration'] = $declaration;
			 $method['body'] = 'return $this->_' . lcfirst($key) . ';';

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
		if (strlen($prop) > 0 && str_contains($prop, '_'))
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

	/**
	 * @param string $value
	 * @return string
	 */
	public function getReturnTypeFromValue(string $value): string
	{
		return $this->getLastSegmentFromPath($value);
	}

	/**
	 * @param array $modules
	 * @param array $props
	 * @return array
	 */
	public function mergeModulesFromProps(array $modules, array $props): array
	{
		$types = new Types();

		foreach ($props as $prop)
		{
			$prop = str_replace('?', '', $prop);

			if( !$types->hasValue($prop) && !$this->isPropInModules($prop, $modules) )
			{
				$modules[] = $prop;
			}
		}

		return $modules;
	}

	/**
	 * @param string $prop
	 * @param array $modules
	 * @return bool
	 */
	public function isPropInModules(string $prop, array $modules): bool
	{
		$modules = array_map(function (string $namespace) use ($prop) {
			if(str_contains($namespace, '\\'))
			{
				$exploded = explode('\\', $namespace);

				return $exploded[count($exploded)-1];
			}

			return $prop;
		}, $modules);

		return in_array(needle: $prop, haystack: $modules);
	}

	/**
	 * @param string $value
	 * @return string
	 */
	public function getLastSegmentFromPath(string $value): string
	{
		if(str_contains($value, '\\'))
		{
			$nullChar = $value[0] === '?' ? '?' : '';

			$exploded = explode('\\', $value);

			$value = $nullChar . $exploded[count($exploded)-1];
		}

		return $value;
	}
}
