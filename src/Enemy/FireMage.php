<?php

namespace GameEnemy;

use GameLogic\Enemy;

use GameArmor as Armor;
use GameCurrency as Currency;

class FireMage extends Enemy
{
    public function __construct()
    {

        $this->__set('dropList', [
            new Currency\Gold,
            new Armor\FireCape
        ]);

        parent::__construct(rand(1, 3), "Человек", "Маг огня", rand(2, 4), rand(9, 12));

        $this->__set('magicAmplification', rand($this->__get('level'), $this->__get('level') * 3));
    }

    public function fightLogic($player, $takedDamage, $isCrit = false)
    {
        $energy = 0;

        $isCrit ? $this->takeDamage($player, $takedDamage, true) : $this->takeDamage($player, $takedDamage);

        if (!$this->__get('isDead')) {
            $this->fireball($player);
        }
    }

    public function fireball($enemy)
    {
        $damageType = "Огонь";
        $dealedDamage = $this->__get('damage') + $this->__get('magicAmplification');
        $enemy->takeDamage($dealedDamage, $damageType);
    }
}
