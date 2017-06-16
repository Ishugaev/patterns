<?php

abstract class Payable
{
    abstract public function toPay(): float;
}

/**
 * The Composite pattern is a simple way of aggregating and then managing groups of similar objects so
 * that an individual object is indistinguishable to a client from a collection of objects.
 * The Composite pattern defines a single inheritance hierarchy that lays down two distinct sets of
 * responsibilities.
 */
abstract class PayableComposite extends Payable
{
    protected $payableItemsCollection = [];

    public function add(Payable $payableItem) {
        array_push($this->payableItemsCollection, $payableItem);
    }

    public function toPay(): float
    {
        $totalPrice = 0;

        foreach ($this->payableItemsCollection as $item) {
            $totalPrice += $item->toPay();
        }

        return $totalPrice;
    }

    public function remove()
    {
        // TODO: Implement remove() method.
    }
}

class Order extends PayableComposite
{
    public function add(Payable $payableItem)
    {
        if ($payableItem instanceof PayableComposite) {
            parent::add($payableItem);
        }
    }
}

class Invoice extends PayableComposite
{

}

class InvoiceLine extends Payable
{
    public function __construct($amountOfItems, $pricePerItem)
    {
        $this->amountOfItems = $amountOfItems;
        $this->pricePerItem = $pricePerItem;
    }

    private $amountOfItems;

    private $pricePerItem;

    public function toPay() : float
    {
        return $this->pricePerItem * $this->amountOfItems;
    }
}

//clientCode
$invoiceLine = new InvoiceLine(2, 10.35);
$invoiceLine2 = new InvoiceLine(1, 30.31);

var_dump($invoiceLine->toPay());
var_dump($invoiceLine2->toPay());


$invoice = new Invoice();
$invoice->add($invoiceLine);
$invoice->add($invoiceLine2);

var_dump($invoice->toPay());

$order = new Order();
$order->add($invoice);

var_dump($order->toPay());