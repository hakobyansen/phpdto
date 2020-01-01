<?php

namespace PhpDto\Services;

class ClassVO
{
	/**
	 * @var string $_namespace
	 */
	private string $_namespace;

	/**
	 * @var null|array $_modules
	 */
	private ?array $_modules;

	/**
	 * @var string $_className
	 */
	private string $_className;

	/**
	 * @var null|array $_traits
	 */
	private ?array $_traits;

	/**
	 * @var null|array $_props
	 */
	private ?array $_props;

	/**
	 * @var null|array $_methods
	 */
	private ?array $_methods;

	/**
	 * @var string $_constructorParam
	 */
	private string $_constructorParam;

	/**
	 * @var null|array $_constructorProps
	 */
	private ?array $_constructorProps;

	/**
	 * @return string
	 */
	public function getNamespace(): string
	{
		return $this->_namespace;
	}

	/**
	 * @param string $namespace
	 * @return ClassVO
	 */
	public function setNamespace( string $namespace ): ClassVO
	{
		$this->_namespace = $namespace;

		return $this;
	}

	/**
	 * @return array|null
	 */
	public function getModules(): ?array
	{
		return $this->_modules;
	}

	/**
	 * @param array|null $modules
	 * @return ClassVO
	 */
	public function setModules( ?array $modules ): ClassVO
	{
		$this->_modules = $modules;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getClassName(): string
	{
		return $this->_className;
	}

	/**
	 * @param string $className
	 * @return ClassVO
	 */
	public function setClassName( string $className ): ClassVO
	{
		$this->_className = $className;

		return $this;
	}

	/**
	 * @return array|null
	 */
	public function getTraits(): ?array
	{
		return $this->_traits;
	}

	/**
	 * @param array|null $traits
	 * @return ClassVO
	 */
	public function setTraits( ?array $traits ): ClassVO
	{
		$this->_traits = $traits;
		return $this;
	}

	/**
	 * @return array|null
	 */
	public function getProps(): ?array
	{
		return $this->_props;
	}

	/**
	 * @param array|null $props
	 * @return ClassVO
	 */
	public function setProps( ?array $props ): ClassVO
	{
		$this->_props = $props;
		return $this;
	}

	/**
	 * @return array|null
	 */
	public function getMethods(): ?array
	{
		return $this->_methods;
	}

	/**
	 * @param array|null $methods
	 * @return ClassVO
	 */
	public function setMethods( ?array $methods ): ClassVO
	{
		$this->_methods = $methods;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getConstructorParam(): string
	{
		return $this->_constructorParam;
	}

	/**
	 * @param string $constructorParam
	 * @return ClassVO
	 */
	public function setConstructorParam( string $constructorParam ): ClassVO
	{
		$this->_constructorParam = $constructorParam;
		return $this;
	}

	/**
	 * @return array|null
	 */
	public function getConstructorProps(): ?array
	{
		return $this->_constructorProps;
	}

	/**
	 * @param array|null $constructorProps
	 * @return ClassVO
	 */
	public function setConstructorProps( ?array $constructorProps ): ClassVO
	{
		$this->_constructorProps = $constructorProps;
		return $this;
	}
}
