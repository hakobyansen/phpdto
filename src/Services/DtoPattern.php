<?php

namespace PhpDto\Services;

use PhpDto\Cli\Handler;

class DtoPattern
{
	/**
	 * @var null|array $_pattern
	 */
	private $_pattern;

	/**
	 * @param Handler $handler
	 */
	public function setPattern( Handler $handler ): void
	{
		if( !$handler->getRules() )
		{
			$fileDir = getenv('PHP_DTO_PATTERNS_DIR').__DIR__ .'//' . $handler->getConfigFile().'.json';

			$resource = fopen($fileDir, 'r');
			$patternJson = fread($resource, filesize($fileDir));
			fclose($resource);

			$pattern = json_decode($patternJson, true);
		}
		else
		{
			$pattern = [
				'class' => $handler->getClassPrefix(),
				'namespace_postfix' => $handler->getNamespacePostfix(),
				'rules' => $this->getRulesFromPattern( $handler->getRules() ),
				'file' => $handler->getConfigFile()
			];
		}

		$this->_pattern = $pattern;
	}

	/**
	 * @return array|null
	 */
	public function getPattern(): ?array
	{
		return $this->_pattern;
	}

	/**
	 * @param string $rulesConfig
	 * @return array
	 */
	public function getRulesFromPattern(string $rulesConfig ): array
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
