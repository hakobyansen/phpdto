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
	private array $_configs;

	/**
	 * @var Handler $_handler
	 */
	private Handler $_handler;

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

		$classDir = str_replace( '\\', '/', getenv('PHP_DTO_NAMESPACE') .'/' .$className.'.php' );

		if( file_exists( $classDir ) )
		{
			$message = "$className already exists.\n";

			throw new \Exception( $message );
		}

		try {
			$handle = fopen( $classDir, 'a+' );

			$invoker = new Invoker();
			$invoker->setCommand( new GenerateDto( new Receiver()) )
				->run( $handle, $this->_configs );

			fclose($handle);
		} catch (\Exception $exception) {
			echo "{$exception->getMessage()}\n";
		}
	}
}
