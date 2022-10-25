<?php

namespace GameLogic;

class Armor extends Item
{

    public $armor;
    

    public function __construct(string $Name, string $Type, int $Rarity, int $Level, int $Cost, int $Armor, float $DropChance)
    {
        $this->armor = $Armor;
        $this->isStacable = false;
        $this->isEquapable = true;
        $this->type = $Type;
        parent::__construct($Name, $Rarity, $Level, $Cost, $DropChance);
        
    }

}
