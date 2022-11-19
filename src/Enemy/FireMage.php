<?php

namespace GameEnemy;

use GameLogic\Enemy;

use GameArmor as Armor;
use GameCurrency as Currency;
use GameWeapon as Weapon;

class FireMage extends Enemy
{
    public function __construct()
    {

        $this->__set('dropList', [
            new Currency\Gold(),
            new Armor\FireCape(),
            new Weapon\FireSword()
        ]);

        parent::__construct(rand(1, 3), "Человек", "Маг огня", rand(2, 4), rand(9, 12));

        $this->__set('magicAmplification', rand($this->__get('level'), $this->__get('level') * 3));
    }

    public function fightLogic($player, $takedDamage, $damageType,  $weaponName, $isCrit = false)
    {
        $energy = 0;

        $isCrit ? $this->takeDamage($player, $takedDamage ,$damageType, $weaponName, true) : $this->takeDamage($player, $takedDamage, $damageType, $weaponName);

        if (!$this->__get('isDead')) {
            $this->fireball($player);
        }
    }

    public function fireball($enemy)
    {
        $damageType = "\e[0;31mОгонь\e[0m";
        $weaponName = "Огненный шар";
        $dealedDamage = $this->__get('damage') + $this->__get('magicAmplification');
        $enemy->takeDamage($dealedDamage, $damageType, $weaponName);
    }
}
