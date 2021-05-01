<?php

namespace Tests\Unit\Cli;

use PhpDto\Cli\Handler;
use PHPUnit\Framework\TestCase;
use Exception;

class HandlerTest extends TestCase
{
	private array $_args;

	private Handler $_handler;

	protected function setUp(): void
	{
		parent::setUp();

		$this->_handler = new Handler();

		$this->_args = [
			'-f=dto_pattern'
		];
	}

	/**
	 * @throws Exception
	 */
	public function testHandleArgs()
	{
		$this->_handler->handleArgs( $this->_args );

		$this->assertEquals(
			'dto_pattern',
			$this->_handler->getConfigFile()
		);
	}
}
