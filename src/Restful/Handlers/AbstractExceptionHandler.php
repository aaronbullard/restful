<?php namespace Aaronbullard\Restful\Handlers;

use Aaronbullard\Restful\ResponseTrait;

abstract class AbstractExceptionHandler implements HandlerInterface {

	use ResponseTrait;

	protected $next;

	protected $exceptionClass;

	abstract protected function handleException(Exception $e);

	protected function next(Exception $e)
	{
		if( isset( $this->next ))
		{
			return $this->next->handle($e);
		}
	}

	public function succeededBy(HandlerInterface $next)
	{
		$this->next = $next;

		return $next;
	}

	public function handle(Exception $e)
	{
		if( is_a($e, static::$exceptionClass) || is_subclass_of($e, static::$exceptionClass) )
		{
			return $this->handleException($e);
		}

		return $this->next($e);
	}
}