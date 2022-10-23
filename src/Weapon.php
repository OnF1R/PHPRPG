<?php

namespace GameLogic;

class Weapon extends Item
{

    public $damage;
    

    public function __construct(string $Name, int $Rarity, int $Level, int $Cost, int $Damage, float $DropChance)
    {
        $this->damage = $Damage;
        $this->isStacable = false;
        $this->isEquapable = true;
        $this->type = "Weapon";
        parent::__construct($Name, $Rarity, $Level, $Cost, $DropChance);
        
    }

}
