<?php

namespace GameLogic;

class Game
{
    public $races = [
        'Человек',
        'Орк',
        'Демон'
    ];

    public $names = [
        "Aaron",
        "Abbey",
        "Abbie",
        "Abby",
        "Abdul",
        "Abe",
        "Abel",
        "Abigail",
        "Abraham",
        "Abram",
        "Ada",
        "Adah",
        "Adalberto",
        "Adaline",
        "Adam",
        "Adam",
        "Adan",
        "Addie"
    ];

    public function createHero()
    {


        $loop = true;

        $health = 10;
        $damage = 2;
        $luck = 0;
        $race = '';
        echo "Создание персонажа.\n";
        $name = (string)readline('Введите имя: ');
        // echo "Обычное!\n";
        // echo "\e[0;32mНеобычное!\e[0m\n"; //Туслый зеленый
        // echo "\e[0;34mРедкое!\e[0m\n"; // Тусклый синий
        // echo "\e[0;31mМифическое!\e[0m\n"; // Тусклый красный
        // echo "\e[1;33mЛегендарное!\e[0m\n"; // Желтый
        // echo "\e[1;32mНеобычное!\e[0m\n"; // Зеленый
        // echo "\e[1;34mРедкое!\e[0m\n"; // Синий
        // echo "\e[1;31mМифическое!\e[0m\n"; // Красный
        echo "\e[1;37mCуществующие расы:\e[0m\n 1. Человек - + 1 к \e[1;33mудаче\e[0m.\n 2. Орк - + 2 к \e[1;31mурону\e[0m.\n 3. Демон - + 10 к \e[1;32mздоровью\e[0m.\n";
        while ($loop) {

            switch ((int)readline('Выберите расу: ')) {
                case 1:
                    echo "Вы выбрали человека.\n";
                    $race = "Человек";
                    $luck += 1;
                    $loop = false;
                    return $this->createPlayer($health, $damage, $race, $name, $luck);
                case 2:
                    echo "Вы выбрали орка.\n";
                    $race = "Орк";
                    $damage += 2;
                    $loop = false;
                    return $this->createPlayer($health, $damage, $race, $name, $luck);
                case 3:
                    echo "Вы выбрали демона.\n";
                    $race = "Демон";
                    $health += 10;
                    $loop = false;
                    return $this->createPlayer($health, $damage, $race, $name, $luck);
                default:
                    echo "Выберите существующий вариант\n";
            }
        }
    }

    public function adventure($player)
    {
        $loop = true;
        while ($loop) {
            echo "\e[1;37mЧто будете делать?\e[0m\n 1. Отравиться в приключение.\n 2. Посетить торговца.\n 3. Инвентарь.\n 4. Характеристики.\n";

            switch ((int)readline('Выберите действие: ')) {
                case 1:
                    if (rand(0, 1)) {
                        $enemy = new Enemy(rand($player->level, ($player->level) + 2), array_rand($this->races, 1), $this->names[array_rand($this->names, 1)]);
                        $this->fight($player, $enemy);
                    } else {
                        echo "Вам повезло избежать драки\n";
                    }
                    break;
                    // $loop = false;
                case 2:
                    # code...
                    $loop = false;
                case 3:
                    $player->inventory->showInventory();
                    break;
                case 4:
                    $this->showStats($player);
                    break;
                case 5:
                    # code...
                    $loop = false;

                default:
                    echo "Выберите существующий вариант\n";
            }
        }
    }

    public function showStats($player)
    {
        echo "Имя: " . "\e[1;37m" . $player->name . "\e[0m\n";
        echo "Уровень: " . "\e[1;37m" . $player->level . "\e[0m\n";
        echo "Раса: " . "\e[1;37m" . $player->race . "\e[0m\n";
        echo "Здоровье: " . "\e[1;32m" . $player->health . "\e[0m\n";
        echo "Урон: " . "\e[1;31m" . $player->damage . "\e[0m\n";
        echo "Удача: " . "\e[1;33m" . $player->luck . "\e[0m\n";
        echo "Броня: " . "\e[1;37m" . $player->armor . "\e[0m\n";
    }

    public function fight($player, $enemy): void
    {
        while ($player->health > 0 && $enemy->health > 0) {
            echo "\e[1;37mНа вас напал\e[0m " . "\e[1;31m" . $enemy->name . "\e[0m" . "\n";
            echo " 1. Атаковать.\n 2. Сбежать.\n";
            switch ((int)readline('Выберите действие: ')) {
                case 1:
                    echo $player->basicAttack($enemy);
                    break;
                case 2:
                    # code...
                    break;
                default:
                    # code...
                    break;
            }
        }
    }

    public function createPlayer($health, $damage, $race, $name, $luck)
    {
        return new Player($health, $damage, $race, $name, $luck);
    }
}
