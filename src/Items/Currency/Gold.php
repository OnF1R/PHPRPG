<?php

namespace GameCurrency;

use GameLogic\StacableItem;

class Gold extends StacableItem
{
    public function __construct()
    {
        parent::__construct("Золото", 6, 1, 1, rand(1, 5), 50);
    }
}
