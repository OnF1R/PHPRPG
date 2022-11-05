<?php

namespace GameLogic;

class Armor extends Item
{

    public $armor;
    public $ability;

    private $stats;

    public function __construct(string $Name, string $Type, int $Rarity, int $Level, int $Cost, int $Armor, float $DropChance, $Ability = null)
    {
        $this->stats = [
            "Strength" => 0,
            "Agility" => 0,
            "Intelligence" => 0,
            "Armor" => 0,
            "Damage" => 0,
        ];

        $this->armor = $Armor;
        $this->isStacable = false;
        $this->isEquapable = true;
        $this->type = $Type;
        $this->ability = $Ability;
        parent::__construct($Name, $Rarity, $Level, $Cost, $DropChance);
    }
}
