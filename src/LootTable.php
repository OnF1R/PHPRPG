<?php

namespace GameLogic;

class LootTable
{
    public $level;
    public $rarity;
    public $mobDropList;
    public $droppedLoot;

    // New Weapon(Name, Rarity, Level, Cost, Damage, DropChance)
    // New StacableItem(Name, Rarity, Level, Cost, Count, DropChance)

    public function __construct()
    {
        $this->mobDropList = [
            new Weapon('Деревянный меч', 0, 1, 3, 2, 5),
            new Weapon('Лук', 0, 1, 3, 2, 5),
            new StacableItem('Яблоко', 0, 0, 1, rand(1, 3), 10),
            new StacableItem('Железная руда', 0, 0, 2, 1, 5),
        ];
    }



    public function dropLoot($level)
    {
        if ($level > 0) {
            $itemsCount = rand(0,2);
            if ($itemsCount !== 0) {
                for ($i = 0; $i < $itemsCount; $i++) {
                    foreach ($this->mobDropList as $drop) {
                        if ($drop->dropChance >= rand(0, 100)) {
                            $this->droppedLoot[$i] = $drop;
                        }
                    }
                }
                return $this->droppedLoot;
            } else {
                return $this->droppedLoot = null;
            }
        }
    }
}
