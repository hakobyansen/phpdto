<?php

namespace PhpDto\Command;

use PhpDto\Services\ClassVO;

abstract class Command implements ICommand
{
	/**
	 * @var Receiver $_writer
	 */
	protected Receiver $_writer;

	/**
	 * Command constructor.
	 * @param Receiver $writer
	 */
	public function __construct( Receiver $writer )
	{
		$this->_writer = $writer;
	}

	/**
	 * @param resource $handle
	 * @param array $dtoConfigs
	 */
	abstract public function execute( $handle, array $dtoConfigs ): void;

	/**
	 * @param array $dtoConfigs
	 * @return ClassVO
	 */
	abstract protected function mapClassVO( array $dtoConfigs ): ClassVO;
}
