<?php

namespace GameLogic;

class Player
{
    public $inventory;

    public $name;
    public $level;
    public $health;
    public $damage;
    public $race;
    
    public $luck;
    public $armor;

    public function __construct(int $Health = 10, int $Damage = 2, string $Race, string $Name , $Luck = 0)
    {
        $this->level = 1;
        $this->health = $Health;
        $this->damage = $Damage;
        $this->race = $Race;
        $this->name = $Name;
        $this->luck = $Luck;
        $this->inventory = new Inventory;
    }

    public function basicAttack($enemy)
    {
        $enemy->health -= $this->damage;
        if ($enemy->health <= 0) {
            return $enemy->death($this);
        } else {
            return $enemy->name . " получил " . $this->damage . " \e[1;31mурона\e[0m, его \e[1;32mздоровье\e[0m " . $enemy->health . "\n";
        }
    }
}
