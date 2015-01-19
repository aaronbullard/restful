<?php namespace Aaronbullard\Restful;

interface ResponseInterface {
	public function respondOK($data);
	public function respondCreated($data);
	public function respondBadRequest($message = 'Bad Request!');
	public function respondUnauthorized($message = 'Unauthorized Request!');
	public function respondForbidden($message = 'Forbidden!');
	public function respondNotFound($message = 'Not Found!');
	public function respondConflict($message = 'Conflict!');
	public function respondFormValidation($message = 'Unprocessable Entity!', array $errors = NULL);
	public function respondInternalError($message = 'Internal Error!');
}