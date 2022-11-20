<?php

namespace GameEnemy;

use GameLogic\Enemy;

use GameArmor as Armor;
use GameCurrency as Currency;
use GameWeapon as Weapon;
use GameItemToCraft as Craft;

class FireMage extends Enemy
{
    private $energy;

    public function __construct()
    {

        $this->__set('dropList', [
            new Currency\Gold(),
            new Armor\FireCape(),
            new Craft\FireShard()
        ]);

        $this->energy = 0;

        parent::__construct(rand(1, 3), "Человек", "Маг огня", rand(2, 4), rand(9, 12));

        $this->__set('magicAmplification', rand($this->__get('level'), $this->__get('level') * 3));
    }

    public function fightLogic($player, $takedDamage, $damageType,  $weaponName, $isCrit = false)
    {
        $isCrit ? $this->takeDamage($player, $takedDamage ,$damageType, $weaponName, true) : $this->takeDamage($player, $takedDamage, $damageType, $weaponName);

        if (!$this->__get('isDead') && $this->energy >= 4) {
            $this->piroblast($player);
            $this->energy = 0;
        } elseif (!$this->__get('isDead')) {
            $this->fireball($player);
        }

        $this->energy++;
    }

    public function fireball($enemy)
    {
        $damageType = "fire";
        $damageTypeText = "\e[0;31mОгонь\e[0m";
        $weaponName = "Огненный шар";
        $dealedDamage = $this->__get('damage') + $this->__get('magicAmplification');
        $enemy->takeDamage($dealedDamage, $damageTypeText, $damageType, $weaponName);
    }

    public function piroblast($enemy)
    {
        $damageType = "fire";
        $damageTypeText = "\e[0;31mОгонь\e[0m";
        $weaponName = "Огненная глыба";
        $dealedDamage = $this->__get('damage') * 4 + $this->__get('magicAmplification');
        $enemy->takeDamage($dealedDamage, $damageTypeText, $damageType, $weaponName);
    }
}
