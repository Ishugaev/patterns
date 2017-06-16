<?php

class RequestHelper {}

abstract class ProcessRequest 
{
    abstract public function process(RequestHelper $request);
}

class MainProcess extends ProcessRequest
{
    public function process(RequestHelper $request) {
        print __CLASS__ . ' @TODO: Implement process request functionality';
    }
}

/**
 * Decorator uses composition and delegation, not just inheritance. Decorator classes hold
 * and instance of another class of their own type.
 *
 * Class Decorator
 */
abstract class RequestDecorator extends ProcessRequest
{
    protected $processRequest;

    public function __construct(ProcessRequest $processRequest) {
        $this->processRequest = $processRequest;
    }
}

class LogRequest extends RequestDecorator
{
    public function process(RequestHelper $request) {
        $this->processRequest->process($request);
        print __CLASS__ .' @TODO: Add logging functionality';
    }
}

class AuthenticateRequest extends RequestDecorator
{
    public function process(RequestHelper $request)
    {
        $this->processRequest->process($request);
        print __CLASS__ . ' @TODO: Add authentication functionality';
    }
}


$process = new AuthenticateRequest(new LogRequest(new MainProcess()));
$process->process(new RequestHelper());


