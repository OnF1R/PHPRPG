<?php

namespace GameLogic;

use GameArmor\FireCape;

class Game
{
    public $races = [
        'Человек',
        'Орк',
        'Демон'
    ];


    public $enemies = [
        'FireMage',
        'FrostMage',
        'WaterMage',
        'PoisonMage',
        'DarkMage'
    ];

    public $craftableItems = [
        'GameWeapon\\FireSword',
    ];

    public function createHero()
    {
        $loop = true;
        $health = 50;
        $damage = 3;
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

            if ($player->__get('isDead')) {
                $player->resurrection();
            }

            echo "\e[1;37mЧто будете делать?\e[0m\n 1. Отравиться в приключение.\n 2. Посетить торговца.\n 3. Инвентарь.\n 4. Экипировка.\n 5. Характеристики.\n 6. Крафт\n";

            switch ((int)readline('Выберите действие: ')) {
                case 1:
                    if (rand(0, 1)) {
                        //$enemy = new Enemy(rand($player->__get('level'), ($player->__get('level')) + 2), $this->races[array_rand($this->races, 1)], $this->names[array_rand($this->names, 1)]);
                        $randomEnemy = "GameEnemy\\" .  $this->enemies[array_rand($this->enemies)];
                        $enemy = new $randomEnemy;
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
                    $player->getInventory()->checkInventory();
                    break;
                case 4:
                    $this->equipmentMenu($player);
                    break;
                case 5:
                    $player->showStats();
                    break;
                case 6:
                    $this->craftMenu($player->getInventory());
                    break;
                case 7:

                case 8:


                default:
                    echo "Выберите существующий вариант\n";
            }
        }
    }

    public function equipmentMenu($player)
    {
        $loop = true;
        while ($loop) {
            echo " 1. Посмотреть экипировку. \n 2. Изменить экипировку.\n 3. Выйти.\n"; {
                switch ((int)readline('Выберите действие: ')) {
                    case 1:
                        $player->showEquipment();
                        break;
                    case 2:
                        $player->changeEquipmentMenu();
                        break;
                    default:
                        $loop = false;
                        break;
                }
            }
        }
    }

    public function fight($player, $enemy)
    {
        echo "\e[1;37mНа вас напал\e[0m " . "\e[1;31m" . $enemy->__get('name') . "\e[0m (Уровень: " . $enemy->__get('level') . ") (" . $enemy->race . ")" . "\n";
        while (!$player->__get('isDead') && !$enemy->isDead) {
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

    public function craftMenu($inventory)
    {
        $loop = true;
        while ($loop) {
            echo " 1. Создать предмет. \n 2. Выйти.\n"; {
                switch ((int)readline('Выберите действие: ')) {
                    case 1:
                        $this->chooseCraft($inventory,);
                        break;
                    default:
                        $loop = false;
                        break;
                }
            }
        }
    }

    public function chooseCraft($inventory)
    {
        echo "Доступные предметы для создания: \n";
        $number = 1;
        $craftableItems = [];
        foreach ($this->craftableItems as $craftableItem) {
            $item = new $craftableItem();
            array_push($craftableItems, $craftableItem);
            echo $number++ . ". \e[1;37m" .  $item->name . "\e[0m, для создания необходимо ( ";
            foreach ($item->craftPattern as $item => $count) {
                echo $item . " (x" . $count . ")";
            }
            echo " )\n";
        }


        $chosedItem = (int)readline('Выберите предмет: ');
        switch (true) {
            case ($chosedItem >= 1 && $chosedItem <= count($this->craftableItems)):
                --$chosedItem;
                (new Craft())->craftItem($inventory, (new $craftableItems[$chosedItem])->craftPattern, (new $craftableItems[$chosedItem]));
                break;
            default:
                echo "Не правильно выбран предмет\n";
                break;
        }
    }

    public function createPlayer($health, $damage, $race, $name, $luck)
    {
        $player = new Player();
        $player->__set('maxHealth', $health);
        $player->__set('currentHealth', $health);
        $player->__set('level', 1);
        $player->__set('damage', $damage);
        $player->__set('race', $race);
        $player->__set('name', $name);
        $player->__set('luck', $luck);
        $player->__set('isDead', false);
        $player->__set('critChance', 0);
        $player->__set('critDamage', 0);
        $player->__set('armor', 0);
        $player->__set('currentExp', 0);
        $player->__set('nextLevelExp', 100);
        $player->__set('missChance', 0);
        $player->__set('magicAmplification', 0);
        $player->createInventory();
        return $player;
    }
}
