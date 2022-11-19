<?php

namespace GameArmor;

use GameLogic\Armor;

class FrostCape extends Armor
{

    private $intelligence;

    public function __construct()
    {
        //Name,Type,Rarity,Cost,Armor,DropChance,Ability
        $this->strength = 3;
        parent::__construct("Ледяной плащ", "Cape", 2, 2, 5, 5, 5);
    }
}
