<?php

namespace GameWeapon;

use GameItemToCraft as Craft;
use GameLogic\Weapon;

class FireSword extends Weapon
{
    // string $Name, int $Rarity, int $Level, int $Cost, int $Damage, float $DropChance

    public $cratPattern;

    public function __construct()
    {
        $this->craftPattern = [
            "Огненный кусочек" => 20,
        ];

        parent::__construct("Огненный меч", 2, 2, 5, 7, 0);
    }
}
