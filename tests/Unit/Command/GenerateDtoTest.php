<?php

namespace Tests\Unit\Command;

use PhpDto\Command\GenerateDto;
use PhpDto\Command\Receiver;
use PhpDto\Services\PropsHelper;
use PHPUnit\Framework\TestCase;

class GenerateDtoTest extends TestCase
{
	private GenerateDto $_command;

	private array $_configs;

	protected function setUp(): void
	{
		parent::setUp();

		$this->_command = new GenerateDto( new Receiver() );

		$this->_configs = [
			'class' => 'item',
			'modules' => [
				'enum' => 'Enum\Enum',
			],
			'props' => [
				'id' => 'int',
				'count' => '?int',
				'name' => 'string',
				'description' => '?string'
			]
		];
	}

	public function testMapClassVO()
	{
		putenv('PHP_DTO_NAMESPACE=App\DTO');
		putenv('PHP_DTO_CLASS_POSTFIX=DTO');

		$classVO = $this->_command->mapClassVO( $this->_configs );

		$this->assertEquals(
			'App\DTO',
			$classVO->getNamespace()
		);

		$this->assertEquals(
			'ItemDTO',
			$classVO->getClassName()
		);

		$this->assertEquals(
			['enum' => 'Enum\Enum'],
			$classVO->getModules()
		);

		$this->assertEquals(
			[ 'DtoSerialize' ],
			$classVO->getTraits()
		);

		$this->assertEquals(
			[
				'private int $_id;',
				'private ?int $_count;',
				'private string $_name;',
				'private ?string $_description;',
			],
			$classVO->getProps()
		);

		$this->assertEquals(
			$this->_configs['class'],
			$classVO->getConstructorParam()
		);

		$this->assertEquals(
			[
				'id', 'count', 'name', 'description'
			],
			PropsHelper::getPropNames(props: $classVO->getConstructorProps())
		);

		$this->assertEquals(
			[
				[
					'visibility' => 'public',
					'declaration' => 'function getId(): int',
					'body' => 'return $this->_id;'
				],
				[
					'visibility' => 'public',
					'declaration' => 'function getCount(): ?int',
					'body' => 'return $this->_count;'
				],
				[
					'visibility' => 'public',
					'declaration' => 'function getName(): string',
					'body' => 'return $this->_name;'
				],
				[
					'visibility' => 'public',
					'declaration' => 'function getDescription(): ?string',
					'body' => 'return $this->_description;'
				],
			],
			$classVO->getMethods()
		);
	}
}
