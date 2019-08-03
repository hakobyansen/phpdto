<?php

namespace PhpDto\Services;

use PhpDto\Cli\Handler;

class DtoConfig
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

			$resource = fopen($fileDir, 'r');
			$configsJson = fread($resource, filesize($fileDir));
			fclose($resource);

			$configs = json_decode($configsJson, true);
		}
		else
		{
			$configs = [
				'class' => $handler->getClassPrefix(),
				'namespace_postfix' => $handler->getNamespacePostfix(),
				'rules' => $this->getRulesFromConfig( $handler->getRules() ),
				'file' => $handler->getConfigFile()
			];
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

	/**
	 * @param string $rulesConfig
	 * @return array
	 */
	public function getRulesFromConfig( string $rulesConfig ): array
	{
		$rules = [];

		$exploded = explode(',', $rulesConfig);

		foreach ( $exploded as $value )
		{
			$value = explode(':', $value);

			$rules = array_merge($rules, [
				$value[0] => $value[1]
			]);
		}

		return $rules;
	}
}
