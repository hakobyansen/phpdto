<?php

namespace PhpDto\Types;

class Prop
{
	/**
	 * @var string
	 */
	private string $_name;

	/**
	 * @var bool
	 */
	private bool $_nullable;

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->_name;
	}

	/**
	 * @param string $name
	 * @return Prop
	 */
	public function setName(string $name): Prop
	{
		$this->_name = $name;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isIsNullable(): bool
	{
		return $this->_nullable;
	}

	/**
	 * @param bool $isNullable
	 * @return Prop
	 */
	public function setIsNullable(bool $isNullable): Prop
	{
		$this->_nullable = $isNullable;
		return $this;
	}
}
