<?php

namespace GameEnemy;

use GameLogic\Enemy;

use GameArmor as Armor;
use GameCurrency as Currency;
use GameWeapon as Weapon;

class DarkMage extends Enemy
{
    private $energy;
    private $transition;

    public function __construct()
    {

        $this->__set('dropList', [
            new Currency\Gold(),
            new Armor\FireCape()
        ]);

        $this->energy = 0;
        $this->transition = false;

        parent::__construct(rand(2, 4), "Человек", "Тёмный маг", rand(2, 6), rand(9, 12));

        $this->__set('magicAmplification', rand($this->__get('level'), $this->__get('level') * 5));
    }

    public function fightLogic($player, $takedDamage, $damageType,  $weaponName, $isCrit = false)
    {
        if(!$this->transition && $this->__get('currentHealth') <= 10) {$this->transformToDemon();}

        $isCrit ? $this->takeDamage($player, $takedDamage ,$damageType, $weaponName, true) : $this->takeDamage($player, $takedDamage, $damageType, $weaponName);

        if($this->transition) {
            if (!$this->__get('isDead') && $this->energy >= 5) {
                $this->demonicalDestroy($player);
                $this->energy = 0;
            } elseif (!$this->__get('isDead')) {
                $this->demonblast($player);
            }
        } else {
            if (!$this->__get('isDead') && $this->energy >= 4) {
                $this->darkblast($player);
                $this->energy = 0;
            } elseif (!$this->__get('isDead')) {
                $this->darkshot($player);
            }
        }

        $this->energy++;
    }

    public function darkshot($enemy)
    {
        $damageType = "dark";
        $damageTypeText = "\e[0;90mТьма\e[0m";
        $weaponName = "Стрела тьмы";
        $dealedDamage = $this->__get('damage') + $this->__get('magicAmplification');
        $enemy->takeDamage($dealedDamage, $damageTypeText, $damageType, $weaponName);
    }

    public function darkblast($enemy)
    {
        $damageType = "dark";
        $damageTypeText = "\e[0;90mТьма\e[0m";
        $weaponName = "Взрыв тьмы";
        $dealedDamage = $this->__get('damage') * 4 + $this->__get('magicAmplification');
        $enemy->takeDamage($dealedDamage, $damageTypeText, $damageType, $weaponName);
    }

    public function demonblast($enemy) {
        $damageType = "dark";
        $damageTypeText = "\e[0;90mТьма\e[0m";
        $weaponName = "Демонический взрыв";
        $dealedDamage = $this->__get('damage') * 2 + $this->__get('magicAmplification');
        $enemy->takeDamage($dealedDamage, $damageTypeText, $damageType, $weaponName);
    }

    public function demonicalDestroy($enemy) {
        $damageType = "dark";
        $damageTypeText = "\e[0;90mТьма\e[0m";
        $weaponName = "Демоническое уничтожение";
        $dealedDamage = $this->__get('damage') * 7 + $this->__get('magicAmplification');
        $enemy->takeDamage($dealedDamage, $damageTypeText, $damageType, $weaponName);
    }

    public function transformToDemon() {
        echo $this->__get('name') . " использовал тёмное обращение.\n";
        $this->__set('name', 'Темно-демон');
        $this->healMaxHealth();
        $this->__set('damage', $this->__get('damage') * 2);
        $this->transition = true;
    }
}
