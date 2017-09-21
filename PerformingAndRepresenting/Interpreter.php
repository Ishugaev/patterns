<?php

abstract class Expression
{
    private static $keycount = 0;
    private $key;

    abstract public function interpret(InterpreterContext $context);

    /**
     * Provides a mechanism by setting unique key per each expression
     */
    public function getKey()
    {
        if (!isset($this->key)) {
            self::$keycount++;
            $this->key = self::$keycount;
        }

        return $this->key;
    }
}

class LiteralExpression extends Expression
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * In fact currently it just set expression to InterpreterContext internal expressionsStore
     *
     * @param InterpreterContext $context
     */
    public function interpret(InterpreterContext $context)
    {
        $context->replace($this, $this->value);
    }
}

class VariableExpression extends Expression
{
    private $name;
    private $value;

    public function __construct($name, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->name;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function interpret(InterpreterContext $context)
    {
        if ($this->value !== null) {
            $context->replace($this, $this->value);
            $this->value = null;
        }

    }
}

class InterpreterContext
{
    private $expressionsStore = [];

    /**
     * Set expression to the $expressions store
     *
     * @param Expression $expression
     * @param $value
     */
    public function replace(Expression $expression, $value)
    {
        $this->expressionsStore[$expression->getKey()] = $value;
    }

    /**
     * Get expression value by expression key from expressionsStore
     *
     * @param Expression $expression
     * @return mixed
     */
    public function lookup(Expression $expression)
    {
        return $this->expressionsStore[$expression->getKey()];
    }
}


//client code

$context = new InterpreterContext();

$literal = new LiteralExpression('hundred');
$literal->interpret($context);

$variable = new VariableExpression('dbName');
$variable->setValue('prod_db');
$variable->interpret($context);

//should return 'hundred'
print $context->lookup($literal);

//should return 'prod_db'
print $context->lookup($variable);