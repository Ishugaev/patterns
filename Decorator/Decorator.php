<?php

class RequestHelper 
{
  
}

abstract class ProcessRequest 
{
  abstract function process(RequestHelper $request);
}

/**
 * Class Decorator
 */
abstract class ProcessDecorator extends ProcessRequest
{
  protected $processRequest;
  
  public function __construct(ProcessRequest $processRequest)
  {
    $this->processRequest = $processRequest;
  }
}
