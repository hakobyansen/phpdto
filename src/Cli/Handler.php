<?php

namespace PhpDto\Cli;

class Handler
{
	/**
	 * @var string|null
	 */
	private ?string $_configFile;

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

	/**
	 * @return void
	 */
	public function init(): void
	{
		$configFileSource = __DIR__.'/../../configs/phpdto-default.json';
		$configFileDestination = getcwd() . '/phpdto.json';
		$patternsFileDir = getcwd() . '/phpdto_patterns';

		$this->createConfigFile($configFileSource, $configFileDestination);
		$this->createPatternsDir($patternsFileDir);
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

	/**
	 * @param string $source
	 * @param string $destination
	 * @return void
	 */
	private function createConfigFile( string $source, string $destination ): void
	{
		if ( !file_exists($destination) )
		{
			if( copy( $source, $destination ) )
			{
				echo "{$destination} configuration file successfully copied to " . getcwd() . " directory.\n";
			}
			else
			{
				echo "Something went wrong while copying the {$destination} file.\n";
			}
		}
		else
		{
			echo  "{$destination} file already exists.\n";
		}
	}

	/**
	 * @param string $dirName
	 * @return void
	 */
	private function createPatternsDir( string $dirName ): void
	{
		if( !file_exists($dirName) )
		{
			if( mkdir( $dirName, 755) )
			{
				echo "{$dirName} directory created successfully.\n";
			}
			else
			{
				echo "Something went wrong while creating the {$dirName} directory.\n";
			}
		}
		else
		{
			echo "{$dirName} directory already exists.\n";
		}
	}
}
