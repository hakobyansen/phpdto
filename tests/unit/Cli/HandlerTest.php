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
			'-c=Item',
			'-n=\Item',
			'-r=id:int,count:nullable|int,name:string,description:nullable|string',
			'-f=dto_pattern'
		];
	}

	public function testHandleArgs()
	{
		$this->_handler->handleArgs( $this->_args );

		$this->assertEquals(
			$this->_handler->getRules(),
			'id:int,count:nullable|int,name:string,description:nullable|string'
		);

		$this->assertEquals(
			$this->_handler->getNamespacePostfix(),
			'\Item'
		);

		$this->assertEquals(
			$this->_handler->getClassPrefix(),
			'Item'
		);

		$this->assertEquals(
			$this->_handler->getConfigFile(),
			'dto_pattern'
		);

		// Making namespace to be null to test it with nullable value
		unset($this->_args[1]);
		$this->_handler->setNamespacePostfix( null );

		$this->_handler->handleArgs( $this->_args );

		$this->assertNull( $this->_handler->getNamespacePostfix() );
	}
}