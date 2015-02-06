<?php namespace Aaronbullard\Restful\Handlers;

use Exception;

interface HandlerInterface {
	public function getExceptionClassName();
	public function handle(Exception $e);
}