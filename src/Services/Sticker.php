<?php

namespace PhpDto\Services;

class Sticker
{
	/**
	 * @var string $_output
	 */
	private string $_output = '';

	/**
	 * @return string
	 */
	public function getOutput(): string 
	{
		return $this->_output;
	}

	/**
	 * @param string $namespace
	 * @return Sticker
	 */
	public function head( string $namespace ): Sticker
	{
		$str = '<?php' . PHP_EOL . PHP_EOL;

		$str .= 'namespace ' . $namespace . ';';

		$this->_output .= $str;

		return $this;
	}

	/**
	 * @param array $modules
	 * @return Sticker
	 */
	public function modules( array $modules ): Sticker
	{
		$str = '';

		foreach ($modules as $module) {
			$str .= 'use ' . $module . ';' . PHP_EOL;
		}

		if (strlen($str)) {
			$this->_output .= $str;
		}

		return $this;
	}

	/**
	 * @param string $className
	 * @param string|null $parentClassName
	 * @return Sticker
	 */
	public function class( string $className, string $parentClassName = null ): Sticker
	{
		$str = 'class ' . $className;

		if ($parentClassName)
		{
			$str .= ' extends ' . $parentClassName;
		}

		$str .= PHP_EOL . '{' . PHP_EOL;

		$this->_output .= $str;

		return $this;
	}

	/**
	 * @param array $traits
	 * @return Sticker
	 */
	public function traits( array $traits ): Sticker
	{
		$str = '';

		foreach ($traits as $trait) {
			$str .= "\t" . 'use ' . $trait . ';' . PHP_EOL;
		}

		$this->_output .= $str;

		return $this;
	}

	/**
	 * @param array $props
	 * @return Sticker
	 */
	public function props( array $props ): Sticker
	{
		$str = '';

		foreach ($props as $prop) {
			$str .= "\t" . $prop . PHP_EOL;
		}

		if (strlen($str))
		{
			$this->_output .= $str;
		}

		return $this;
	}

	/**
	 * @param string $param
	 * @param array $props
	 * @return Sticker
	 */
	public function constructor( string $param, array $props ): Sticker
	{
		$str = "\t" . 'public function __construct( array $' . $param . ' )' . PHP_EOL
			. "\t" . '{' . PHP_EOL;

		foreach ($props as $prop)
		{
			$nullHandler = str_contains(haystack: $prop, needle: '?') ? ' ?? null' : '';

			$str .= "\t\t" . '$this->_' . $prop . ' = $' .
				$param . "['" . strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $prop)) . "']" .
				$nullHandler . ";\n";
		}

		$str .= "\t" . '}';

		$this->_output .= $str;

		return $this;
	}

	/**
	 * @param array $methods
	 * @return Sticker
	 */
	public function methods( array $methods ): Sticker
	{
		$str = '';

		$counter = 0;
		$count = count($methods);

		foreach ($methods as $method)
		{
			$str .= "\t" . $method['visibility'] . ' ' . $method['declaration'] . PHP_EOL
				. "\t" . '{' . PHP_EOL . "\t\t" . $method['body'] . PHP_EOL . "\t" . '}'.PHP_EOL;

			// Put double EOL for all methods except last one
			if( $counter != $count-1 )
			{
				$str .= PHP_EOL;
			}

			$counter++;
		}

		if ( strlen($str) )
		{
			$str .= '}';

			$this->_output .= $str;
		}

		return $this;
	}

	/**
	 * @return Sticker
	 */
	public function eol(): Sticker
	{
		$this->_output .= PHP_EOL;

		return $this;
	}
}
