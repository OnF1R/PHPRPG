<?php

namespace GameEnemy;

use GameLogic\Enemy;

use GameArmor as Armor;
use GameCurrency as Currency;

class FrostMage extends Enemy
{

    private $energy;

    public function __construct()
    {

        $this->__set('dropList', [
            new Currency\Gold,
            new Armor\FrostCape
        ]);

        $this->energy = 0;

        parent::__construct(rand(1, 3), "Человек", "Маг льда", rand(2, 4), rand(9, 12));

        $this->__set('magicAmplification', rand($this->__get('level'), $this->__get('level') * 3));
    }

    public function fightLogic($player, $takedDamage, $damageType, $weaponName, $isCrit = false)
    {
        $isCrit ? $this->takeDamage($player, $takedDamage, $damageType, $weaponName, true) : $this->takeDamage($player, $takedDamage, $damageType, $weaponName);

        if (!$this->__get('isDead') && $this->energy >= 3) {
            $this->ultraSnowball($player);
            $this->energy = 0;
        } elseif (!$this->__get('isDead')) {
            $this->snowball($player);
        }

        $this->energy++;
    }

    public function snowball($enemy)
    {
        $damageType = "ice";
        $damageTypeText = "\e[0;34mЛед\e[0m";
        $weaponName = "Снежок";
        $dealedDamage = $this->__get('damage') + $this->__get('magicAmplification');
        $enemy->takeDamage($dealedDamage, $damageTypeText, $damageType, $weaponName);
    }

    public function ultraSnowball($enemy)
    {
        $damageType = "ice";
        $damageTypeText = "\e[0;34mЛед\e[0m";
        $weaponName = "Ультра снежок";
        $dealedDamage = $this->__get('damage') * 3 + $this->__get('magicAmplification');
        $enemy->takeDamage($dealedDamage, $damageTypeText, $damageType,  $weaponName);
    }
}
