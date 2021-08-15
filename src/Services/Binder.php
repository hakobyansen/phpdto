<?php

namespace PhpDto\Services;

use PhpDto\Types\Prop;

class Binder
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
	 * @return Binder
	 */
	public function head( string $namespace ): Binder
	{
		$str = '<?php' . PHP_EOL . PHP_EOL;

		$str .= 'namespace ' . $namespace . ';';

		$this->_output .= $str;

		return $this;
	}

	/**
	 * @param array $modules
	 * @return Binder
	 */
	public function modules( array $modules ): Binder
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
	 * @return Binder
	 */
	public function class( string $className, string $parentClassName = null ): Binder
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
	 * @return Binder
	 */
	public function traits( array $traits ): Binder
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
	 * @return Binder
	 */
	public function props( array $props ): Binder
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
	 * @param Prop[] $props
	 * @return Binder
	 */
	public function constructor( string $param, array $props ): Binder
	{
		$str = "\t" . 'public function __construct( array $' . $param . ' )' . PHP_EOL
			. "\t" . '{' . PHP_EOL;

		foreach ($props as $prop)
		{
			$propName = $prop->getName();
			$nullHandler = $prop->isIsNullable() ? ' ?? null' : '';

			$str .= "\t\t" . '$this->_' . $propName . ' = $' .
				$param . "['" . strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $propName)) . "']" .
				$nullHandler . ";\n";
		}

		$str .= "\t" . '}';

		$this->_output .= $str;

		return $this;
	}

	/**
	 * @param array $methods
	 * @return Binder
	 */
	public function methods( array $methods ): Binder
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
	 * @return Binder
	 */
	public function eol(): Binder
	{
		$this->_output .= PHP_EOL;

		return $this;
	}
}
