<?php namespace Aaronbullard\Restful\Handlers;

use Exception;
use ReflectionClass;

class HttpExceptionHandler extends AbstractExceptionHandler implements HandlerInterface {

	protected static $exceptionClass = 'Aaronbullard\\Exceptions\\HttpException';

	protected function handleException(Exception $e)
	{
		$reflection = new ReflectionClass($e);

		$exceptionName = $reflection->getShortName();

		$method = 'respond' . rtrim($exceptionName, 'Exception');

		$responder = $this->getResponder();

		if(method_exists($responder, $method))
		{
			return $responder->{$method}($e->getMessage());
		}

		throw $e;
	}

}