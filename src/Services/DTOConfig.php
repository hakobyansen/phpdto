<?php

namespace PhpDto\Services;

use PhpDto\Cli\Handler;

class DTOConfig
{
	/**
	 * @var null|array $_configs
	 */
	private $_configs;

	/**
	 * @param Handler $handler
	 */
	public function setConfigs( Handler $handler ): void
	{
		if( !$handler->getRules() )
		{
			$fileDir = getenv('PHP_DTO_CONFIG_FILES_DIR').__DIR__ .'//' . $handler->getConfigFile().'.json';

			$handle = fopen($fileDir, 'r');
			$configsJson = fread($handle, filesize($fileDir));
			fclose($handle);

			$configs = json_decode($configsJson, true);
		}
		else
		{
			$configs = $handler->getRules();

		}

		$this->_configs = $configs;
	}

	/**
	 * @return array|null
	 */
	public function getConfigs(): ?array
	{
		return $this->_configs;
	}
}
