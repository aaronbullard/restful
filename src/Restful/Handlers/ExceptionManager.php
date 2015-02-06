<?php namespace Aaronbullard\Restful\Handlers;

use Exception, ReflectionClass;

class ExceptionManager {

	protected $handlers = [];

	public function registerHandler(HandlerInterface $handler)
	{
		$this->handlers[] = $handler;

		return $this;
	}
/*
	public function handle(Exception $e)
	{
		$exceptionClassName = get_class( $e );

		$handler = $this->findApproriateHandler($exceptionClassName);

		if( ! $handler ){
			throw $e;
		}

		return $handler->handle($e);
	}
//*/
	public function handle(Exception $e)
	{
		foreach($this->handlers as $handler)
		{
			try{
				return $handler->handle($e);
			}
			catch(Exception $e)
			{
				continue;
			}
		}

		throw $e;
	}

	protected function findApproriateHandler($exceptionClassName)
	{
		foreach( $this->handlers as $handler)
		{
			if($exceptionClassName === $handler->getExceptionClassName())
			{
				return $handler;
			}
		}

		$reflParentClass = (new ReflectionClass($exceptionClassName))->getParentClass();

		if( ! $reflParentClass )
		{
			return FALSE;
		}

		return $this->findApproriateHandler($reflParentClass->getName());
	}
}