<?php

namespace PhpDto\Services;

use PhpDto\Cli\Handler;

class DtoPattern
{
	/**
	 * @var null|array $_pattern
	 */
	private ?array $_pattern;

	/**
	 * @param Handler $handler
	 */
	public function setPattern( Handler $handler ): void
	{
		$fileDir = getenv('PHP_DTO_PATTERNS_DIR') .'/' . $handler->getConfigFile().'.json';

		$resource = fopen($fileDir, 'r');
		$patternJson = fread($resource, filesize($fileDir));
		fclose($resource);

		$pattern = json_decode($patternJson, true);

		$this->_pattern = $pattern;
	}

	/**
	 * @return array|null
	 */
	public function getPattern(): ?array
	{
		return $this->_pattern;
	}
}
