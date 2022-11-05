<?php

namespace GameArmor;

use GameLogic\Armor;

class FireCape extends Armor
{

    private $intelligence;

    public function __construct()
    {
        //Name,Type,Rarity,Cost,Armor,DropChance,Ability
        $this->intelligence = 3;
        parent::__construct("Огненный плащ", "Cape", 2, 2, 5, 5, 100);
    }
}
