<?php

namespace PhpDto\Services;

use PhpDto\Cli\Handler;
use PhpDto\Command\GenerateDto;
use PhpDto\Command\Invoker;
use PhpDto\Command\Receiver;

class Maker
{
	/**
	 * @var array $_configs
	 */
	private $_configs;

	/**
	 * @var Handler $_handler
	 */
	private $_handler;

	/**
	 * Maker constructor.
	 * @param array $configs
	 * @param Handler $handler
	 */
	public function __construct( array $configs, Handler $handler )
	{
		$this->_configs = $configs;
		$this->_handler = $handler;
	}

	/**
	 * @throws \Exception
	 */
	public function makeDTO()
	{
		$dtoBuilder = new DtoBuilder();

		$className = $dtoBuilder->getClassName( $this->_configs );

		$classDir = getenv('PHP_DTO_NAMESPACE') .'/' .$className.'.php';

		if( file_exists( $classDir ) )
		{
			$message = "$className already exists.\n";

			throw new \Exception( $message );
		}

		$handle = fopen( $classDir, 'a+' );

		$invoker = new Invoker();
		$invoker->setCommand( new GenerateDto( new Receiver()) )
			->run( $handle, $this->_configs );

		fclose($handle);
	}
}
