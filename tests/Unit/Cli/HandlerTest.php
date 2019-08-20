<?php

namespace Tests\Unit\Cli;

use PhpDto\Cli\Handler;
use PHPUnit\Framework\TestCase;

class HandlerTest extends TestCase
{
	/**
	 * @var array $_args
	 */
	private $_args;

	/**
	 * @var Handler $_handler
	 */
	private $_handler;

	protected function setUp(): void
	{
		parent::setUp();

		$this->_handler = new Handler();

		$this->_args = [
			'-f=dto_pattern'
		];
	}

	/**
	 * @throws \Exception
	 */
	public function testHandleArgs()
	{
		$this->_handler->handleArgs( $this->_args );

		$this->assertEquals(
			$this->_handler->getConfigFile(),
			'dto_pattern'
		);
	}
}
