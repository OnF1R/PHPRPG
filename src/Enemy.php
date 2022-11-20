<?php

namespace GameLogic;

use GameArmor as Armor;
use GameCurrency as Currency;

abstract class Enemy
{
    private $maxHealth;
    private $currentHealth;

    private $damage;
    private $race;
    private $name;
    private $lootTable;
    private $dropList;
    private $level;
    private $armor;

    private $isDead;
    private $missChance;
    private $magicAmplification;

    private $critChance;
    private $critDamage;

    public function __construct(int $Level, string $Race, string $Name, int $Damage = 2, int $maxHealth = 10)
    {
        $this->__set('level', $Level);
        $this->__set('maxHealth', rand($maxHealth * $Level - 5, $maxHealth * $Level + 5));
        $this->__set('race', $Race);
        $this->__set('damage',$Damage);
        $this->__set('name',$Name);

        $this->lootTable = new LootTable;

        if ($Race === "Орк") {
            $this->__set('damage', $this->__get('damage') + 2);
        }
        if ($Race === "Демон") {
            $this->__set('maxHealth', $this->__get('maxHealth') + 10);
        }

        $this->__set('critChance',rand(0, 15));

        $this->__set('critDamage', rand(10, 100));

        $this->__set('armor', rand(0, 25));

        $this->__set('currentHealth', $this->__get('maxHealth'));

        $this->__set('isDead', false);
    }

    public function __set($name, $value)
    {
        $properties = [
            'name',
            'level',
            'maxHealth',
            'currentHealth',
            'damage',
            'race',
            'armor',
            'critChance',
            'critDamage',
            'isDead',
            'missChance',
            'magicAmplification',
            'dropList',
        ]; // разрешенные свойства

        if (in_array($name, $properties)) {
            $this->$name = $value;
        }
    }

    public function __get($name)
    {
        $properties = [
            'name',
            'level',
            'maxHealth',
            'currentHealth',
            'damage',
            'race',
            'armor',
            'critChance',
            'critDamage',
            'isDead',
            'missChance',
            'magicAmplification',
            'dropList',
        ]; // разрешенные свойства

        if (in_array($name, $properties)) {
            return $this->$name;
        }
    }

    public function healMaxHealth()
    {
        $this->__set('currentHealth', ($this->__get('maxHealth')));
    }

    abstract public function fightLogic($player, $takedDamage, $damageType, $weaponName, $isCrit = false);

    public function takeDamage($player, $takedDamage, $damageTypeText = "Физический", $damageType = "physical", $weaponName = null,  $isCrit = false)
    {
        if (!isset($weaponName)) $weaponName = "Руки"; 

        if (!$isCrit) {
            if ($this->__get('armor') >= rand(1, 100)) {
                $blockedDamage = round($takedDamage / 2);
                $this->__set('currentHealth', $this->__get('currentHealth') - $blockedDamage);
                if ($this->__get('currentHealth') <= 0) {
                    $this->death($player);
                } else {
                    echo $this->__get('name') . " заблокировал удар и получил " . $blockedDamage . " \e[1;31mурона\e[0m, (" . $damageTypeText . " ($weaponName)" . ") его \e[1;32mздоровье\e[0m " . $this->__get('currentHealth') . "\n";
                }
            } else {
                $this->__set('currentHealth', $this->__get('currentHealth') - $takedDamage);
                if ($this->__get('currentHealth') <= 0) {
                    $this->death($player);
                } else {
                    echo $this->__get('name') . " получил " . $takedDamage . " \e[1;31mурона\e[0m, (" . $damageTypeText . " ($weaponName)" . ") его \e[1;32mздоровье\e[0m " . $this->__get('currentHealth') . "\n";
                }
            }
        } else {
            $this->__set('currentHealth', $this->__get('currentHealth') - $takedDamage);
            if ($this->__get('currentHealth') <= 0) {
                $this->death($player);
            } else {
                echo $this->__get('name') . " получил \e[1;31mкритический удар \e[0m" . $takedDamage . " \e[1;31mурона\e[0m, (" . $damageTypeText . ") его \e[1;32mздоровье\e[0m " . $this->__get('currentHealth') . "\n";
            }
        }
    }

    public function basicAttack($enemy)
    {
        if ($this->__get('critChance') >= rand(1, 100)) {
            $dealedDamage = $this->__get('damage') + floor($this->__get('damage') / 100 * $this->__get('critDamage'));
            $enemy->takeDamage($dealedDamage, true);
        } else {
            $enemy->takeDamage($this->__get('damage'));
        }
    }

    public function death($player)
    {
        $this->__set('isDead', true);
        echo $this->__get('name') . " \e[1;31mумер\e[0m\n";
        $droppedLoot = $this->lootTable->dropLoot($this->__get('level'), $this->dropList);
        if (isset($droppedLoot)) {
            foreach ($droppedLoot as $loot) {
                if ($loot->isStacable) {
                    echo "Вы получили " .  $loot->name . " " . "(" . $loot->rarity . ") x" . $loot->count . "\n";
                } else {
                    echo "Вы получили " .  $loot->name . " " . "(" . $loot->rarity . ")\n";
                }
                $player->getInventory()->addItemToInventory($loot);
            }
        } else {
            echo "К сожалению вы ничего не получили...\n";
        }

        $player->takeExp(rand($this->__get('level') * 2, $this->__get('level') * 7));

        // $gainExp = $player->currentExp += rand(9,12) * $this->level;
        // echo "Вы получили " . $gainExp . " опыта\n";
    }
}
