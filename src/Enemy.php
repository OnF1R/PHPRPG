<?php

namespace GameLogic;

class Enemy
{
    public $health;
    public $damage;
    public $race;
    public $name;
    public $lootTable;
    public $level;

    public function __construct(int $Level, string $Race, string $Name, int $Damage = 2, int $Health = 10)
    {
        $this->level = $Level;
        $this->health = rand($Health * $Level - 5, $Health * $Level + 5);
        $this->damage = $Damage;
        $this->race = $Race;
        $this->name = $Name;
        $this->lootTable = new LootTable;
    }

    public function basicAttack($enemy)
    {
        $enemy->health -= $this->damage;
    }

    public function death($player)
    {
        echo $this->name . " \e[1;31mумер\e[0m\n";
        $droppedLoot = $this->lootTable->dropLoot($this->level);
        if (isset($droppedLoot)) {
            foreach ($droppedLoot as $loot) {
                if ($loot->isStacable) {
                    echo "Вы получили " .  $loot->name . " " . "(" . $loot->rarity . ") x" . $loot->count . "\n";
                } else {
                    echo "Вы получили " .  $loot->name . " " . "(" . $loot->rarity . ")\n";
                }
                $player->inventory->addItemToInventory($loot);
            }
        } else {
            echo "К сожалению вы ничего не получили...\n";
        }
    }
}
