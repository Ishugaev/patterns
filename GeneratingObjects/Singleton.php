<?php

class Singleton
{
    private static $instance = null;

    private function __construct()
    {

    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            // initialize your instance
            self::$instance = new SplObjectStorage();
        }

        return self::$instance;
    }
}


//client code
Singleton::getInstance();