<?php namespace Aaronbullard\Restful\Handlers;

use Aaronbullard\Restful\ResponseTrait;
use Exception;
use Aaronbullard\Exceptions\CoreException;
use Aaronbullard\Exceptions\HttpException;
use Aaronbullard\Exceptions\BadRequestException;
use Aaronbullard\Exceptions\ForbiddenException;
use Aaronbullard\Exceptions\InternaServerErrorException;
use Aaronbullard\Exceptions\MethodNotAllowedException;
use Aaronbullard\Exceptions\NotFoundException;
use Aaronbullard\Exceptions\UnauthorizedException;

class LaravelExceptionBus extends ExceptionHandler {

	use ResponseTrait;

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if ( $request->wantsJson() && is_subclass_of($e, 'Aaronbullard\\Exceptions\\CoreException'))
		{
			return $this->handleHttpExceptions($e);
		}

		return parent::render($request, $e);
	}

	public function handleHttpExceptions(Exception $e)
	{
		try{
			throw $e;
		}
		catch(BadRequestException $e)
		{
			return $this->getResponder()->respondBadRequest($e->getMessage());
		}
		catch(NotFoundException $e)
		{
			return $this->getResponder()->respondNotFound($e->getMessage());
		}
		catch(ForbiddenException $e)
		{
			return $this->getResponder()->respondForbidden($e->getMessage());
		}
		catch(UnauthorizedException $e)
		{
			return $this->getResponder()->respondUnauthorized($e->getMessage());
		}
		catch(MethodNotAllowedException $e)
		{
			return $this->getResponder()->respondMethodNotAllowed($e->getMessage());
		}
		catch(InternaServerErrorException $e)
		{
			return $this->getResponder()->respondInternalError($e->getMessage());
		}
		catch(HttpException $e)
		{
			return $this->getResponder()->respondInternalError($e->getMessage());
		}
		catch(CoreException $e)
		{
			return $this->getResponder()->respondInternalError($e->getMessage());
		}
	}

}
