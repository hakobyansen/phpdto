<?php

namespace PhpDto\Cli;

class Handler
{
	/**
	 * @var string $_rules
	 */
	private $_rules;

	/**
	 * @var string $_configFile
	 */
	private $_configFile;

	/**
	 * @var string $_classPrefix;
	 */
	private $_classPrefix;

	/**
	 * @var null|string $_namespacePostfix
	 */
	private $_namespacePostfix;

	/**
	 * @var bool $_generateUnitTest
	 */
	private $_generateUnitTest = true;

	/**
	 * @param array $argv
	 * @return Handler
	 * @throws \Exception
	 */
	public function handleArgs( array $argv ): Handler
	{
		foreach ( $argv as $value )
		{
			$substr = substr( $value, 0, 2 );

			if( $substr == '-r' )
			{
				$this->setRules( substr($value, 3) );
			}
			elseif( $substr == '-c' )
			{
				$this->setClassPrefix( substr($value, 3) );
			}
			elseif( $substr == '-n' )
			{
				$this->setNamespacePostfix( substr($value, 3) );
			}
			elseif( $substr == '-f' )
			{
				$this->setConfigFile( substr($value, 3) );
			}
		}

		if( !$this->getConfigFile() && !$this->getRules() )
		{
			throw new \Exception('Missing arguments.');
		}

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getNamespacePostfix(): ?string
	{
		return $this->_namespacePostfix;
	}

	/**
	 * @param string|null $namespacePostfix
	 * @return Handler
	 */
	public function setNamespacePostfix( ?string $namespacePostfix ): Handler
	{
		$this->_namespacePostfix = $namespacePostfix;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isGenerateUnitTest(): bool
	{
		return $this->_generateUnitTest;
	}

	/**
	 * @param bool $generateUnitTest
	 * @return Handler
	 */
	public function setGenerateUnitTest( bool $generateUnitTest ): Handler
	{
		$this->_generateUnitTest = $generateUnitTest;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getRules(): ?string
	{
		return $this->_rules;
	}

	/**
	 * @param string|null $rules
	 */
	public function setRules( ?string $rules ): void
	{
		$this->_rules = $rules;
	}

	/**
	 * @return string|null
	 */
	public function getConfigFile(): ?string
	{
		return $this->_configFile;
	}

	/**
	 * @param string|null $configFile
	 */
	public function setConfigFile( ?string $configFile ): void
	{
		$this->_configFile = $configFile;
	}

	/**
	 * @return string|null
	 */
	public function getClassPrefix(): ?string
	{
		return $this->_classPrefix;
	}

	/**
	 * @param string|null $classPrefix
	 * @return Handler
	 */
	public function setClassPrefix( ?string $classPrefix ): Handler
	{
		$this->_classPrefix = $classPrefix;
		return $this;
	}
}
