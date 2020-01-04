<?php

namespace PhpDto\Command;

class Invoker
{
	/**
	 * @var ICommand $_command
	 */
	private ICommand $_command;

	/**
	 * @param ICommand $command
	 * @return Invoker
	 */
	public function setCommand( ICommand $command ): Invoker
	{
		$this->_command = $command;

		return $this;
	}

	/**
	 * @param $handle
	 * @param array $dtoConfigs
	 */
	public function run( $handle, array $dtoConfigs )
	{
		$this->_command->execute( $handle, $dtoConfigs );
	}
}
