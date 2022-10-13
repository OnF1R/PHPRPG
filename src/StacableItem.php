<?php

namespace GameLogic;

class StacableItem extends Item
{
    public $isStacable;
    public $count;

    public function __construct(string $Name, int $Rarity, int $Level, int $Cost, int $Count)
    {
        $this->count = $Count;
        $this->isStacable = true;
        parent::__construct($Name, $Rarity, $Level, $Cost);
    }
}
