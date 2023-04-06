<?php

namespace App\Exceptions;

use Exception;

abstract class ClientException extends Exception
{
	public function __construct($message = '', $code = 0, \Throwable $previous = null)
	{
		parent::__construct($this->getCustomMessage(), $this->getCustomCode(), $previous);
	}
	
	abstract protected function getCustomMessage(): string;
	
	abstract protected function getCustomCode(): int;
}