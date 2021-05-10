<?php

namespace Helper;

use Exception;
use Throwable;

class NotFoundException extends Exception
{

	public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

	public function error404()
	{
		http_response_code(404);
		header("Location: /main/error404");
		exit;
	}
}