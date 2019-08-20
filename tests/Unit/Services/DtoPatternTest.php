<?php

namespace Tests\Unit\Services;

use PhpDto\Cli\Handler;
use PhpDto\Services\DtoPattern;
use PHPUnit\Framework\TestCase;

class DtoPatternTest extends TestCase
{
	/**
	 * @var Handler $_handler
	 */
	private $_handler;

	/**
	 * @var DtoPattern $_dtoConfig
	 */
	private $_dtoConfig;

	/**
	 * @throws \Exception
	 */
	protected function setUp(): void
	{
		parent::setUp();

		putenv('PHP_DTO_PATTERNS_DIR='.__DIR__ . '/../../files/');

		$this->_handler   = new Handler();
		$this->_dtoConfig = new DtoPattern();

		$args = [
			'-f=dto_pattern'
		];

		$this->_handler->handleArgs( $args );
		$this->_dtoConfig->setPattern( $this->_handler );
	}

	public function testSetPattern()
	{
		$expected = [
			'class' => 'Item',
			'namespace_postfix' => '\Item',
			'rules' => [
				'id' => 'int',
				'count' => 'nullable|int',
				'name' => 'string',
				'description' => 'nullable|string'
			]
		];

		$this->assertEquals(
			$expected, $this->_dtoConfig->getPattern()
		);
	}
}
