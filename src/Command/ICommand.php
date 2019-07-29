<?php

namespace PhpDto\Command;

interface ICommand
{
	/**
	 * @param $handle
	 * @param array $dtoConfigs
	 */
	public function execute( $handle, array $dtoConfigs ): void;
}
