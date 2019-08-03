<?php

namespace Tests\Unit\Services;

use PhpDto\Cli\Handler;
use PhpDto\Services\DtoConfig;
use PHPUnit\Framework\TestCase;

class DtoConfigTest extends TestCase
{
	/**
	 * @var Handler $_handler
	 */
	private $_handler;

	/**
	 * @var DtoConfig $_dtoConfig
	 */
	private $_dtoConfig;

	protected function setUp(): void
	{
		parent::setUp();

		$this->_handler   = new Handler();
		$this->_dtoConfig = new DtoConfig();

		$args = [
			'-c=Item',
			'-n=\Item',
			'-r=id:int,count:nullable|int,name:string,description:nullable|string',
			'-f=config'
		];

		$this->_handler->handleArgs( $args );
		$this->_dtoConfig->setConfigs( $this->_handler );
	}

	public function testSetConfigs()
	{
		$expected = [
			'class' => 'Item',
			'namespace_postfix' => '\Item',
			'rules' => [
				'id' => 'int',
				'count' => 'nullable|int',
				'name' => 'string',
				'description' => 'nullable|string'
			],
			'file' => 'config'
		];

		$this->assertEquals(
			$expected, $this->_dtoConfig->getConfigs()
		);
	}

	public function testGetRulesFromConfig()
	{
		$rulesConfig = 'id:int,count:nullable|int,name:string,description:nullable|string';

		$expected = [
			'id' => 'int',
			'count' => 'nullable|int',
			'name' => 'string',
			'description'=> 'nullable|string'
		];

		$this->assertEquals(
			$expected, $this->_dtoConfig->getRulesFromConfig( $rulesConfig )
		);
	}
}
