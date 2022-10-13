<?php

namespace GameLogic;

abstract class Item
{

    public $name;
    public $rarity;
    public $level;
    public $cost;
    // echo "\e[1;33mЛегендарное!\e[0m\n"; // Желтый
    // echo "\e[1;32mНеобычное!\e[0m\n"; // Зеленый
    // echo "\e[1;34mРедкое!\e[0m\n"; // Синий
    // echo "\e[1;31mМифическое!\e[0m\n"; // Красный
    public function __construct(string $Name, int $Rarity, int $Level, int $Cost)
    {
        $this->name = $Name;
        switch ($Rarity) {
            case 1:
                $this->rarity = "\e[1;32mНеобычное\e[0m";
                break;
            case 2:
                $this->rarity = "\e[1;34mРедкое\e[0m";
                break;
            case 3:
                $this->rarity = "\e[1;35mЭпическое\e[0m";
                break;
            case 4:
                $this->rarity = "\e[1;33mЛегендарное\e[0m";
                break;
            case 5:
                $this->rarity = "\e[1;31mМифическое\e[0m";
                break;
            default:
                $this->rarity = "\e[1;37mОбычное\e[0m";
                break;
        }
        $this->level = $Level;
        $this->cost = $Cost;
    }
}
