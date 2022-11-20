<?php

namespace GameItemToCraft;

use GameLogic\StacableItem;

class FireShard extends StacableItem {

    public function __construct()
    {
        parent::__construct("Огненный кусочек", 1, 1, 1, rand(1, 2000), 100);
    }

}
