<?php

namespace GameLogic;

class StacableItem extends Item
{
    public $count;

    public function __construct(string $Name, int $Rarity, int $Level, int $Cost, int $Count, float $DropChance)
    {
        $this->count = $Count;
        $this->isStacable = true;
        $this->isEquapable = false;
        parent::__construct($Name, $Rarity, $Level, $Cost, $DropChance);
    }
}
