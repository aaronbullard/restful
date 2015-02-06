<?php namespace Aaronbullard\Restful\Handlers;

use Illuminate\Support\ServiceProvider;

class ExceptionHandlerServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->singleton('Aaronbullard\\Restful\\Handlers\\HandlerInterface', 'Aaronbullard\\Restful\\Handlers\\HttpExceptionHandler');
	}
}