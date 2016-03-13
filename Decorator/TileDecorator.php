<?php


abstract class Tile
{
    abstract function getWealthFactor();
}

class Plains extends Tile
{
    private $wealthFactor = 2;

    public function getWealthFactor()
    {
        return $this->wealthFactor;
    }
}

abstract class TileDecorator extends Tile
{
    protected $tile;

    public function __construct(Tile $tile)
    {
        $this->tile = $tile;
    }
}

class DiamondDecorator extends TileDecorator
{
    private $wealthFactor = 10;

    public function getWealthFactor()
    {
        return $this->tile->getWealthFactor() + $this->wealthFactor;
    }
}

class ForestDecorator extends TileDecorator
{
    private $wealthFactor = 4;

    public function getWealthFactor()
    {
        return $this->tile->getWealthFactor() + $this->wealthFactor;
    }
}

class RadioactivePollutionDecorator extends  TileDecorator
{
    private $wealthFactor = 100;

    public function getWealthFactor()
    {
        return $this->tile->getWealthFactor() - $this->wealthFactor;
    }
}


$plains = new Plains();
print $plains->getWealthFactor();


$diamondPlains = new DiamondDecorator($plains);
print $diamondPlains->getWealthFactor();


$forestDiamondPlains = new ForestDecorator(new DiamondDecorator($plains));
print $forestDiamondPlains->getWealthFactor();

$radioactiveForestDiamondPlains = new RadioactivePollutionDecorator(
    new ForestDecorator(new DiamondDecorator($plains))
);
print $radioactiveForestDiamondPlains->getWealthFactor();
