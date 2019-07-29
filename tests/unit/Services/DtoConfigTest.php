<?php

namespace Tests\Unit\Services;

use PhpDto\Cli\Handler;
use PhpDto\Services\DTOConfig;
use PHPUnit\Framework\TestCase;

class DtoConfigTest extends TestCase
{
	/**
	 * @var Handler $_handler
	 */
	private $_handler;

	/**
	 * @var DTOConfig $_dtoConfig
	 */
	private $_dtoConfig;

	protected function setUp(): void
	{
		parent::setUp();

		$this->_handler   = new Handler();
		$this->_dtoConfig = new DTOConfig();
	}
}
