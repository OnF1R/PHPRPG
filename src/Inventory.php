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

    public function getEquipableItems($itemType) {
        return $this->inventorySortForItemType($itemType);
    }

    public function checkInventory($itemType = null, $uniqueSort = false)
    {
        if (!empty($this->inventory)) {
            if ($uniqueSort) {
                $equipableItems = $this->inventorySortForItemType($itemType);
                if (empty($equipableItems)) {
                    $title = "Подходящей экипировки нет";
                    echo "\e[1;37m" . $title . "\e[0m\n";
                } else {
                    $title = "Подходящая экипировка:";
                    $this->showInventory($equipableItems, $title);
                }
            } else {
                $this->inventorySort();
                $title = "Ваш инвентарь:";
                $this->showInventory($this->inventory, $title);
            }
        } else {
            $title = "Инвентарь пуст";
            echo "\e[1;37m" . $title . "\e[0m\n";
        }
    }

    public function showInventory($inventory, $title)
    {
        echo "\e[1;37m" . $title . "\e[0m\n";
        $number = 1;
        foreach ($inventory as $item) {
            if ($item->isStacable) {
                echo " " .  $number . ". " . $item->name . " " . "(" . $item->rarity . ") x" . $item->count . "\n";
            } else {
                if ($item->isEquiped) {
                    echo " " .  $number . ". " . $item->name . " " . "(" . $item->rarity . ") \e[1;37m Экипировано\e[0m\n";
                } else {
                    echo " " .  $number . ". " . $item->name . " " . "(" . $item->rarity . ")\n";
                }
            }
            $number++;
        }
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
                    }
                }
            } else {
                if ($this->inventory[$i]->type == $itemType) {
                    array_push($tempArray, $this->inventory[$i]);
                }
            }
        }
        return $tempArray;
    }
}
