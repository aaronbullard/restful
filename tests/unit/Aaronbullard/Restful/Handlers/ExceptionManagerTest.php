<?php
namespace Aaronbullard\Restful\Handlers;

use Mockery;
use Aaronbullard\Exceptions\HttpException;
use Aaronbullard\Exceptions\NotFoundException;
use Aaronbullard\Exceptions\ForbiddenException;

class ExceptionManagerTest extends \Codeception\TestCase\Test
{
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected $manager;

	protected function _before()
	{
		$this->manager = new ExceptionManager;
		$this->exception = new NotFoundException;
	}

	protected function _after()
	{
		Mockery::close();
	}

	public function makeHandler($e, $exceptionName, $isHandled = 0)
	{
		$mock = Mockery::mock('Aaronbullard\\Restful\\Handlers\\SomeExceptionHandler', 'Aaronbullard\\Restful\\Handlers\\HandlerInterface');
		$mock->shouldReceive('getExceptionClassName')->andReturn($exceptionName);
		$mock->shouldReceive('handle')->with($e)->times($isHandled)->andReturn(TRUE);

		return $mock;
	}

	// tests
	public function testRegisteringHandlers()
	{
		$handler = $this->makeHandler($this->exception, 'Aaronbullard\\Exceptions\\NotFoundException');
		$this->manager->registerHandler($handler);
	}

	public function testHandlingException()
	{
		$handler = $this->makeHandler($this->exception, 'Aaronbullard\\Exceptions\\NotFoundException', 1);
		$this->manager->registerHandler($handler);

		$result = $this->manager->handle( $this->exception );

		$this->assertTrue( $result );
	}

	public function testHandlingChildException()
	{
		$handler1 = $this->makeHandler($this->exception, 'Aaronbullard\\Exceptions\\HttpException', 1);
		$handler2 = $this->makeHandler(new ForbiddenException, 'Aaronbullard\\Exceptions\\ForbiddenException', 0);
		$this->manager->registerHandler($handler1);
		$this->manager->registerHandler($handler2);

		$result = $this->manager->handle( $this->exception );

		$this->assertTrue( $result );
	}

	public function testExceptionThrownIfNotHandled()
	{
		$handler = $this->makeHandler(new ForbiddenException, 'Aaronbullard\\Exceptions\\ForbiddenException', 0);
		$this->manager->registerHandler($handler);

		$this->setExpectedException('Aaronbullard\\Exceptions\\NotFoundException');
		$result = $this->manager->handle( new NotFoundException );
	}

}