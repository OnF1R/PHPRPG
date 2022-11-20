<?php

namespace GameEnemy;

use GameLogic\Enemy;

use GameArmor as Armor;
use GameCurrency as Currency;
use GameWeapon as Weapon;

class WaterMage extends Enemy
{
    private $energy;

    public function __construct()
    {

        $this->__set('dropList', [
            new Currency\Gold(),
            new Armor\FireCape()
        ]);

        $this->energy = 0;

        parent::__construct(rand(1, 3), "Человек", "Маг воды", rand(2, 4), rand(9, 12));

        $this->__set('magicAmplification', rand($this->__get('level'), $this->__get('level') * 3));
    }

    public function fightLogic($player, $takedDamage, $damageType,  $weaponName, $isCrit = false)
    {
        $isCrit ? $this->takeDamage($player, $takedDamage ,$damageType, $weaponName, true) : $this->takeDamage($player, $takedDamage, $damageType, $weaponName);

        if (!$this->__get('isDead') && $this->energy >= 3) {
            $this->tsunami($player);
            $this->energy = 0;
        } elseif (!$this->__get('isDead')) {
            $this->waterball($player);
        }

        $this->energy++;
    }

    public function waterball($enemy)
    {
        $damageType = "water";
        $damageTypeText = "\e[0;34mВода\e[0m";
        $weaponName = "Водяной шар";
        $dealedDamage = $this->__get('damage') + $this->__get('magicAmplification');
        $enemy->takeDamage($dealedDamage, $damageTypeText, $damageType, $weaponName);
    }

    public function tsunami($enemy)
    {
        $damageType = "water";
        $damageTypeText = "\e[0;34mВода\e[0m";
        $weaponName = "Цунами";
        $dealedDamage = $this->__get('damage') * rand(2,5) + $this->__get('magicAmplification');
        $enemy->takeDamage($dealedDamage, $damageTypeText, $damageType, $weaponName);
    }
}
