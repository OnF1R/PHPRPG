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

    public $isDead;

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
        $this->isDead = false;
        $this->currentHealth = $this->maxHealth;
    }

    public function basicAttack($enemy)
    {
        if ($this->critChance >= rand(1, 100)) {
            $dealedDamage = $this->damage + floor($this->damage / 100 * $this->critDamage);
        } else {
            $dealedDamage = $this->damage;
        }

        $enemy->fightLogic($this, $dealedDamage);
    }

    public function takeDamage($takedDamage, $isCrit = false)
    {
        if (!$isCrit) {
            if ($this->armor >= rand(1, 100)) {
                $blockedDamage = round($takedDamage / 2);
                $this->currentHealth -= $blockedDamage;
                if ($this->currentHealth <= 0) {
                    $this->death($this);
                } else {
                    echo $this->name . " заблокировал удар и получил " . $blockedDamage . " \e[1;31mурона\e[0m, его \e[1;32mздоровье\e[0m " . $this->currentHealth . "\n";
                }
            } else {
                $this->currentHealth -= $takedDamage;
                if ($this->currentHealth <= 0) {
                    $this->death($this);
                } else {
                    echo $this->name . " получил " . $takedDamage . " \e[1;31mурона\e[0m, его \e[1;32mздоровье\e[0m " . $this->currentHealth . "\n";
                }
            }
        } else {
            $this->currentHealth -= $takedDamage;
            if ($this->currentHealth <= 0) {
                $this->death($this);
            } else {
                echo $this->name . " получил \e[1;31mкритический удар \e[0m" . $takedDamage . " \e[1;31mурона\e[0m, его \e[1;32mздоровье\e[0m " . $this->currentHealth . "\n";
            }
        }
    }

    public function death($player)
    {
        echo "К сожалению " . $this->name . " \e[1;31mумер\e[0m\n";
        $this->currentHealth = $this->maxHealth;
        $this->isDead = true;
    }

    public function resurrection()
    {
        $this->isDead = false;
        echo $this->name . " \e[1;32mвозрождён\e[0m\n";
    }
}
