<?php

require_once 'legacy_functions.php';

class Product
{
    private $price;

    private $name;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}

/**
 * The Facade pattern is a way of providing a simple, clear interface to complex systems
 */
class ProductFacade
{
    private $products = [];

    private $file;

    public function __construct($file)
    {
        $this->file = $file;
        $this->compile();
    }

    private function compile()
    {
        $lines = getProductFileLines($this->file);
        foreach ($lines as $line) {
            $price = getPriceFromLine($line);
            $name = getNameFromLine($line);
            $this->products[] = new Product($name, $price);
        }
    }

    public function getProducts()
    {
        return $this->products;
    }

}

$productPrice = new ProductFacade('price.csv');
print_r($productPrice->getProducts());