<?php

namespace GameLogic;

class Player
{
    public $inventory;

    public $name;
    public $level;
    public $maxHealth;
    public $currentHealth;
    public $damage;
    public $race;

    public $luck;
    public $armor;

    public $critChance;
    public $critDamage;

    public function __construct(int $maxHealth = 50, int $Damage = 3, string $Race, string $Name, $Luck = 0)
    {
        $this->level = 1;
        $this->maxHealth = $maxHealth;
        $this->damage = $Damage;
        $this->race = $Race;
        $this->name = $Name;
        $this->luck = $Luck;
        $this->armor = 0;
        $this->critChance = 0;
        $this->critDamage = 0;
        $this->inventory = new Inventory;

        $this->currentHealth = $this->maxHealth;
    }

    public function basicAttack($enemy)
    {
        $dealedDamage = $this->damage;

        $enemy->fightLogic($this, $dealedDamage);
    }

    public function death($player)
    {
        echo "К сожалению " . $this->name . " \e[1;31mумер\e[0m\n";
        $this->currentHealth = $this->maxHealth;
        return 0;
    }
}
