<?php namespace Aaronbullard\Restful;

use Illuminate\Support\Facades\App;

trait ResponseTrait {

	public function getResponder()
	{
		return App::make('Aaronbullard\\Restful\\ResponseInterface');
	}
}