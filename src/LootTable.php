<?php

namespace GameLogic;

class LootTable
{
    public $level;
    public $rarity;
    public $mobDropList;

    // New Weapon(Name, Rarity, Level, Cost, Damage)

    public function __construct()
    {
        $this->mobDropList = [
            new Weapon('Деревянный меч', 0, 1, 3, 2),
            new Weapon('Лук', 0, 1, 3, 2),
            new StacableItem('Яблоко', 0 , 0, 1, rand(1,3)),
            new StacableItem('Железная руда', 0 , 0, 2, 1),
        ];
    }

    public $droppedLoot;

    public function dropLoot($level)
    {
        if ($level > 0) {
            $itemsCount = rand(0, 2);
            if ($itemsCount !== 0) {
                for ($i = 0; $i < $itemsCount; $i++) {
                    $this->droppedLoot[$i] = $this->mobDropList[rand(0, count($this->mobDropList) - 1)];
                }
                return $this->droppedLoot;
            } else {
                return $this->droppedLoot = null;
            }
        }
    }
}
