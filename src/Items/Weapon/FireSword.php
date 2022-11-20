<?php

namespace GameWeapon;

use GameLogic\Weapon;

class FireSword extends Weapon
{
    // string $Name, int $Rarity, int $Level, int $Cost, int $Damage, float $DropChance

    public function __construct()
    {
        parent::__construct("Огненный меч", 2, 2, 5, 7, 0);
    }
}
