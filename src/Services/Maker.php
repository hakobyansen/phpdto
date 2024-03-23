<?php

namespace PhpDto\Services;

use PhpDto\Command\Command;
use PhpDto\Command\GenerateDto;
use PhpDto\Command\Invoker;
use PhpDto\Command\Receiver;

class Maker
{
	/**
	 * @var array $_configs
	 */
	private array $_configs;

	/**
	 * Maker constructor.
	 * @param array $configs
	 */
	public function __construct( array $configs )
	{
		$this->_configs = $configs;
	}

	/**
	 * @throws \Exception
	 */
	public function makeClass()
	{
		$dtoBuilder = new DtoBuilder();

		$className = $dtoBuilder->getClassName( $this->_configs );
		$namespace = $dtoBuilder->getNamespace( $this->_configs );

		$classDir = str_replace(
			search: '\\',
			replace: '/',
			subject: $namespace
		);

		if( !is_dir($classDir) )
		{
			mkdir( $classDir, 0755, true );
		}

		$classPath = $classDir . '/' .$className.'.php';

		if( file_exists( $classPath ) )
		{
			$message = "$className already exists.\n";

			throw new \Exception( $message );
		}

		try {
			$handle = fopen( $classPath, 'a+' );

			$invoker = new Invoker();
			$invoker->setCommand( new GenerateDto( new Receiver()) )
				->run( $handle, $this->_configs );

			fclose($handle);
		} catch (\Exception $exception) {
			echo "{$exception->getMessage()}\n";
		}
	}
}
