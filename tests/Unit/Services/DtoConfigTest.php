<?php

namespace Tests\Unit\Services;

use PhpDto\Services\DtoConfig;
use PHPUnit\Framework\TestCase;

class DtoConfigTest extends TestCase
{
	/**
	 * @var DtoConfig $_dtoConfig
	 */
	private $_dtoConfig;
	
	protected function setUp(): void
	{
		parent::setUp();

		$this->_dtoConfig = new DtoConfig();
		$configFilePath = getcwd() . '/configs/phpdto-default.json';

		$this->_dtoConfig->setVariables( $configFilePath );
	}

	public function testGetVariable()
	{
		$patternsDir = $this->_dtoConfig->getVariable( DtoConfig::PATTERNS_DIR );
		$dtoNamespace = $this->_dtoConfig->getVariable( DtoConfig::DTO_NAMESPACE );
		$classPostfix = $this->_dtoConfig->getVariable( DtoConfig::CLASS_POSTFIX );

		$this->assertEquals( $patternsDir, 'phpdto_patterns' );
		$this->assertEquals( $dtoNamespace, 'App\Dto' );
		$this->assertEquals( $classPostfix, 'Dto' );
	}
}
