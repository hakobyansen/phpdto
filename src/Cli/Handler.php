<?php

namespace PhpDto\Cli;

class Handler
{
	/**
	 * @var string $_configFile
	 */
	private string $_configFile;

	/**
	 * @param array $argv
	 * @return Handler
	 * @throws \Exception
	 */
	public function handleArgs( array $argv ): Handler
	{
		foreach ( $argv as $value )
		{
			$substr = substr( $value, 0, 2 );

			if( $substr === '-f' )
			{
				$this->setConfigFile( substr($value, 3) );
			}
		}

		return $this;
	}

	public function init(): void
	{
		$source = __DIR__.'/../../configs/phpdto-default.json';
		$destination = getcwd() . '/phpdto.json';

		if ( !file_exists($destination) )
		{
			if( copy( $source, $destination ) )
			{
				echo 'phpdto.json configuration file successfully copied to ' . getcwd() . " directory.\n";
			}
			else
			{
				echo "Something went wrong.\n";
			}
		}
		else
		{
			echo  "Initialization failed because {$destination} file already exists.\n";
		}
	}

	/**
	 * @return string|null
	 */
	public function getConfigFile(): ?string
	{
		return $this->_configFile;
	}

	/**
	 * @param string|null $configFile
	 */
	public function setConfigFile( ?string $configFile ): void
	{
		$this->_configFile = $configFile;
	}
}
