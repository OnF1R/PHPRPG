<?php

namespace GameArmor;

use GameLogic\Armor;

class RustyHelmet extends Armor
{

    public function __construct()
    {
        parent::__construct("Ржавый шлем", "Helmet", 2, 2, 5, 3, 5);
    }
}
