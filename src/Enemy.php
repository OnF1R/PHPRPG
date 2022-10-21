<?php

namespace GameLogic;

class Enemy
{
    public $maxHealth;
    public $currentHealth;

    public $damage;
    public $race;
    public $name;
    public $lootTable;
    public $level;
    public $armor;

    public $isDead;

    public $critChance;
    public $critDamage;

    public function __construct(int $Level, string $Race, string $Name, int $Damage = 2, int $maxHealth = 10)
    {
        $this->level = $Level;
        $this->maxHealth = rand($maxHealth * $Level - 5, $maxHealth * $Level + 5);
        $this->race = $Race;
        $this->damage = $Damage;
        $this->name = $Name;
        $this->lootTable = new LootTable;

        if ($this->race === "Орк") {
            $this->damage += 2;
        }
        if ($this->race === "Демон") {
            $this->maxHealth += 10;
        }

        $this->critChance = rand(0, 15);

        $this->critDamage = rand(10, 100);

        $this->armor = rand(0, 25);

        $this->currentHealth = $this->maxHealth;

        $this->isDead = false;
    }

    public function fightLogic($player, $takedDamage)
    {
        $energy = 0;

        $this->takeDamage($player, $takedDamage);

        if (!$this->isDead) {
            $this->basicAttack($player);
        }
    }

    public function takeDamage($player, $takedDamage)
    {
        if ($this->armor >= rand(1, 100)) {
            $blockedDamage = round($takedDamage / 2);
            $this->currentHealth -= $blockedDamage;
            if ($this->currentHealth <= 0) {
                $this->death($player->inventory);
            } else {
                echo $this->name . " заблокировал удар и получил " . $blockedDamage . " \e[1;31mурона\e[0m, его \e[1;32mздоровье\e[0m " . $this->currentHealth . "\n";
            }
        } else {
            $this->currentHealth -= $takedDamage;
            if ($this->currentHealth <= 0) {
                $this->death($player->inventory);
            } else {
                echo $this->name . " получил " . $takedDamage . " \e[1;31mурона\e[0m, его \e[1;32mздоровье\e[0m " . $this->currentHealth . "\n";
            }
        }
    }

    public function basicAttack($enemy)
    {
        if ($this->critChance >= rand(1, 100)) {
            $dealedDamage = $this->damage + floor($this->damage / 100 * $this->critDamage);
            $enemy->takeDamage($dealedDamage, true);
        } else {
            $enemy->takeDamage($this->damage);
        }
    }

    public function death($inventory)
    {
        $this->isDead = true;
        echo $this->name . " \e[1;31mумер\e[0m\n";
        $droppedLoot = $this->lootTable->dropLoot($this->level);
        if (isset($droppedLoot)) {
            foreach ($droppedLoot as $loot) {
                if ($loot->isStacable) {
                    echo "Вы получили " .  $loot->name . " " . "(" . $loot->rarity . ") x" . $loot->count . "\n";
                } else {
                    echo "Вы получили " .  $loot->name . " " . "(" . $loot->rarity . ")\n";
                }
                $inventory->addItemToInventory($loot);
            }
        } else {
            echo "К сожалению вы ничего не получили...\n";
        }
    }
}
