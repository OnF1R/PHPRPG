<?php

namespace GameLogic;

use GameArmor as Armor;
use GameCurrency as Currency;

class LootTable
{
    public $level;
    public $rarity;
    public $mobDropList;
    public $droppedLoot;
    public $abilities;
    public $weaponsLevel_1;

    // New Weapon(Name, Rarity, Level, Cost, Damage, DropChance)
    // New StacableItem(Name, Rarity, Level, Cost, Count, DropChance)

    public function __construct()
    {

        // $this->mobDropList = [
        //     new Currency\Gold,
        //     new Armor\FireCape,
        //     new Armor\RustyHelmet,
        // ];
    }



    public function dropLoot($level, $dropList)
    {
        if ($level > 0) {
            $itemsCount = rand(0, 2);
            if ($itemsCount !== 0) {
                for ($i = 0; $i < $itemsCount; $i++) {
                    foreach ($dropList as $drop) {
                        if ($drop->dropChance >= rand(0, 100)) {
                            $this->droppedLoot[$i] = clone $drop;
                        }
                    }
                }
                return $this->droppedLoot;
            } else {
                return null;
            }
        }
    }
}
