<?php

namespace GameLogic;

class Inventory
{

    public $inventory = [];

    public function addItemToInventory($item)
    {
        if ($item->isStacable) {
            $itemsNames = [];
            foreach ($this->inventory as $alreadyItem) {
                array_push($itemsNames, $alreadyItem->name);
            }
            if (in_array($item->name, $itemsNames)) {
                $this->inventory[array_search($item->name, $itemsNames)]->count += $item->count;
            } else {
                array_push($this->inventory, $item);
            }
        } else {
            array_push($this->inventory, $item);
        }
    }

    public function showInventory($itemType = null, $uniqueSort = false)
    {
        $tempInventory = $this->inventory;

        if (!empty($this->inventory)) {
            if ($uniqueSort) {

                $this->inventorySortForItemType($itemType);
                $title = "Подходящая экипировка:";
            } else {
                $this->inventorySort();
                $title = "Ваш инвентарь:";
            }
            $number = 1;
            echo "\e[1;37m" . $title . "\e[0m\n";
            foreach ($this->inventory as $item) {
                if ($item->isStacable) {
                    echo " " .  $number . ". " . $item->name . " " . "(" . $item->rarity . ") x" . $item->count . "\n";
                } else {
                    echo " " .  $number . ". " . $item->name . " " . "(" . $item->rarity . ")\n";
                }
                $number++;
            }
        } else {
            if ($uniqueSort) {
                $title = "Подходящей экипировки нет";
            } else {
                $title = "Инвентарь пуст";
            }
            echo "\e[1;37m" . $title . "\e[0m\n";
        }

        $this->inventory = $tempInventory;
    }

    public function inventorySort()
    {
        $tempArrayStacable = [];
        $tempArrayNotStacable = [];
        for ($i = 0; $i < count($this->inventory); $i++) {
            if ($this->inventory[$i]->isStacable) {
                array_push($tempArrayStacable, $this->inventory[$i]);
            } else {
                array_push($tempArrayNotStacable, $this->inventory[$i]);
            }
        }
        $this->inventory = array_merge($tempArrayStacable, $tempArrayNotStacable);
    }

    public function inventorySortForItemType($itemType)
    {
        $tempArray = [];
        for ($i = 0; $i < count($this->inventory); $i++) {
            if (is_array($itemType)) {
                foreach ($itemType as $type) {
                    if ($this->inventory[$i]->type == $type) {
                        array_push($tempArray, $this->inventory[$i]);
                        print_r($this->inventory[$i]);
                    }
                }
            } else {
                if ($this->inventory[$i]->type == $itemType) {
                    array_push($tempArray, $this->inventory[$i]);
                    print_r($this->inventory[$i]);
                }
            }
        }
        $this->inventory = $tempArray;
    }
}
