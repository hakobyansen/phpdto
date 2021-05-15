<?php

namespace Tests\Unit\Cli;

use PhpDto\Cli\Handler;
use PHPUnit\Framework\TestCase;
use Exception;

class HandlerTest extends TestCase
{
	private Handler $_handler;

	protected function setUp(): void
	{
		parent::setUp();

		$this->_handler = new Handler();
	}

	/**
	 * @throws Exception
	 */
	public function testHandleArgs()
	{
		$this->_handler->handleArgs(['phpdto', '-f=dto_pattern']);

		$this->assertEquals(
			'dto_pattern.json',
			$this->_handler->getConfigFile()
		);

		$this->_handler->handleArgs(['phpdto', '-f', 'dto_pattern']);

		$this->assertEquals(
			'dto_pattern.json',
			$this->_handler->getConfigFile()
		);

		$this->_handler->handleArgs(['phpdto', '-f', 'dto_pattern.json']);

		$this->assertEquals(
			'dto_pattern.json',
			$this->_handler->getConfigFile()
		);
	}
}
