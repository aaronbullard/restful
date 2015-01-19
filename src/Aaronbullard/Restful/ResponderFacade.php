<?php namespace Aaronbullard\Restful;

class ResponderFacade implements ResponseInterface {

	protected $responder;

	public function __construct(Responder $responder)
	{
		$this->responder = $responder;
	}

	protected function respondSuccess($data)
	{
		$this->responder->setStatus('success');
		$this->responder->setData($data);
	}

	protected function respondError($message, array $errors = [])
	{
		$this->responder->setStatus('error');
		$this->responder->setErrors($message, $errors);
	}


	public function respondOK($data = [])
	{
		$this->respondSuccess($data);

		$this->responder->setHttpCode(200);

		return $this->responder->respond();
	}


	public function respondCreated($data = [])
	{
		$this->respondSuccess($data);

		$this->responder->setHttpCode(201);

		return $this->responder->respond();
	}


	public function respondBadRequest($message = 'Bad Request!')
	{
		$this->respondError($message);

		$this->responder->setHttpCode(400);

		return $this->responder->respond();
	}


	public function respondUnauthorized($message = 'Unauthorized Request!')
	{
		$this->respondError($message);

		$this->responder->setHttpCode(401);
		
		return $this->responder->respond();
	}


	public function respondForbidden($message = 'Forbidden!')
	{
		$this->respondError($message);

		$this->responder->setHttpCode(403);
		
		return $this->responder->respond();
	}


	public function respondNotFound($message = 'Not Found!')
	{
		$this->respondError($message);

		$this->responder->setHttpCode(404);
		
		return $this->responder->respond();
	}


	public function respondConflict($message = 'Conflict!')
	{
		$this->respondError($message);

		$this->responder->setHttpCode(409);
		
		return $this->responder->respond();
	}


	public function respondFormValidation($message = 'Unprocessable Entity!', array $errors = NULL)
	{
		$this->respondError($message, $errors);

		$this->responder->setHttpCode(422);
		
		return $this->responder->respond();
	}


	public function respondInternalError($message = 'Internal Error!')
	{
		$this->respondError($message);

		$this->responder->setHttpCode(500);
		
		return $this->responder->respond();
	}

}