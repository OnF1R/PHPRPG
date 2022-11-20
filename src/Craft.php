<?php

namespace GameLogic;

class Craft {

    public function craftItem($inventory, $neededItems, $craftItem) {
        if(is_array($neededItems)) {
            foreach ($neededItems as $item => $count) {
                $inventory->deleteFromInventory($item, $count);
            }
        }
        $inventory->addItemToInventory($craftItem);
    }

}
