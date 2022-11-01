<?php

namespace GameLogic;

class Abilities
{
    public function fireAura($unit, $enemy)
    {
        if ($unit->takeDamage()) {
            $enemy->currentHealth -= 3;
            echo $enemy->name . " получил 3 единицы урона от огненной ауры предмета " . $this->name;
        }
    }
}
