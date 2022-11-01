<?php

namespace GameLogic;

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
        $this->abilities = new Abilities;;

        $this->mobDropList = [
            new StacableItem("\e[1;33mЗолото\e[0m", 6, 1, 1, rand(1, 4), 50),
            new Weapon('Деревянный меч', 0, 1, 3, 2, 7),
            new Weapon('Лук', 0, 1, 3, 2, 7),
            new Armor("Ржавый шлем", "Helmet", 0, 1, 3, 2, 7),
            new StacableItem('Яблоко', 0, 0, 1, rand(1, 3), 25),
            new StacableItem('Железная руда', 0, 0, 2, rand(1, 3), 12),
            new Armor("Огненный плащ", "Cape", 2, 3, 12, 0, 100),
        ];

        $this->weaponsLevel_1 = [
            new Weapon('Деревянный меч', 0, 1, 3, 2, 5),
            new Weapon('Лук', 0, 1, 3, 2, 5),
        ];
    }



    public function dropLoot($level)
    {
        if ($level > 0) {
            $itemsCount = rand(0, 2);
            if ($itemsCount !== 0) {
                for ($i = 0; $i < $itemsCount; $i++) {
                    foreach ($this->mobDropList as $drop) {
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
