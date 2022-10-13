<?php

namespace GameLogic;

class Weapon extends Item
{

    public $damage;
    public $isStacable;


    public function __construct(string $Name, int $Rarity, int $Level, int $Cost, int $Damage)
    {
        $this->damage = $Damage;
        $this->isStacable = false;
        parent::__construct($Name, $Rarity, $Level, $Cost);
        
    }

}
