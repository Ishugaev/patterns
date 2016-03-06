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
 * The main idea of Decorator pattern is that we store object in some property inside class Decorator
 * and then applying custom Decorator logic; instead of just using inheritance
 *
 * Class Decorator
 */
abstract class ProcessDecorator extends ProcessRequest
{
    protected $processRequest;

    public function __construct(ProcessRequest $processRequest) {
        $this->processRequest = $processRequest;
    }
}

class LogRequest extends ProcessDecorator
{
    public function process(RequestHelper $request) {
        $this->processRequest->process();
        print __CLASS__ .' @TODO: Add logging functionality';
    }
}

class AuthenticateRequest extends ProcessDecorator
{
    public function process(RequestHelper $request)
    {
        $this->processRequest->process();
        print __CLASS__ . ' @TODO: Add authentication functionality';
    }
}

$process = new AuthenticateRequest(new LogRequest(new MainProcess()));
$process->process(new RequestHelper());