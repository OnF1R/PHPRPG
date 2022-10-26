<?php

namespace GameLogic;

class Player
{
    public $inventory;

    public $name;
    public $level;
    public $maxHealth;
    public $currentHealth;
    public $damage;
    public $race;
    public $nextLevelExp;
    public $currentExp;


    public $equipment;


    public $luck;
    public $armor;

    public $critChance;
    public $critDamage;

    public $isDead;

    public function __construct(int $maxHealth = 50, int $Damage = 3, string $Race, string $Name, $Luck = 0)
    {
        $this->level = 1;
        $this->maxHealth = $maxHealth;
        $this->damage = $Damage;
        $this->race = $Race;
        $this->name = $Name;
        $this->luck = $Luck;
        $this->armor = 0;
        $this->critChance = 0;
        $this->critDamage = 0;
        $this->inventory = new Inventory;
        $this->isDead = false;
        $this->currentHealth = $this->maxHealth;

        $this->equipment = [
            "LeftHand" => new Weapon("", 0, 0, 0, 0, 0),
            "RightHand" => new Weapon("", 0, 0, 0, 0, 0),
            "Helmet" => new Weapon("", 0, 0, 0, 0, 0),
            "Chest" => new Weapon("", 0, 0, 0, 0, 0),
            "Gloves" => new Weapon("", 0, 0, 0, 0, 0),
            "Leggs" => new Weapon("", 0, 0, 0, 0, 0),
            "Boots" => new Weapon("", 0, 0, 0, 0, 0),
            "FirstRing" => new Weapon("", 0, 0, 0, 0, 0),
            "SecondRing" => new Weapon("", 0, 0, 0, 0, 0),
            "Cape" => new Weapon("", 0, 0, 0, 0, 0),
            "Trinket" => new Weapon("", 0, 0, 0, 0, 0),
        ];
    }

    public function basicAttack($enemy)
    {
        if ($this->critChance >= rand(1, 100)) {
            $dealedDamage = $this->damage + floor($this->damage / 100 * $this->critDamage);
        } else {
            $dealedDamage = $this->damage;
        }

        $enemy->fightLogic($this, $dealedDamage);
    }

    public function takeDamage($takedDamage, $isCrit = false)
    {
        if (!$isCrit) {
            if ($this->armor >= rand(1, 100)) {
                $blockedDamage = round($takedDamage / 2);
                $this->currentHealth -= $blockedDamage;
                if ($this->currentHealth <= 0) {
                    $this->death($this);
                } else {
                    echo $this->name . " заблокировал удар и получил " . $blockedDamage . " \e[1;31mурона\e[0m, его \e[1;32mздоровье\e[0m " . $this->currentHealth . "\n";
                }
            } else {
                $this->currentHealth -= $takedDamage;
                if ($this->currentHealth <= 0) {
                    $this->death($this);
                } else {
                    echo $this->name . " получил " . $takedDamage . " \e[1;31mурона\e[0m, его \e[1;32mздоровье\e[0m " . $this->currentHealth . "\n";
                }
            }
        } else {
            $this->currentHealth -= $takedDamage;
            if ($this->currentHealth <= 0) {
                $this->death($this);
            } else {
                echo $this->name . " получил \e[1;31mкритический удар \e[0m" . $takedDamage . " \e[1;31mурона\e[0m, его \e[1;32mздоровье\e[0m " . $this->currentHealth . "\n";
            }
        }
    }

    public function death($player)
    {
        echo "К сожалению " . $this->name . " \e[1;31mумер\e[0m\n";
        $this->currentHealth = $this->maxHealth;
        $this->isDead = true;
    }

    public function resurrection()
    {
        $this->isDead = false;
        echo $this->name . " \e[1;32mвозрождён\e[0m\n";
    }

    public function equip($item, $slot)
    {
        if (isset($this->equipment[$slot])) {
            $this->equipment[$slot]->isEquiped = false;
        }
        $this->equipment[$slot] = $item;

        $this->equipment[$slot]->isEquiped = true;

        echo "Эпикирован предмет " . $item->name . " (" . $item->rarity . ")\n";
    }

    public function showStats()
    {
        echo "Имя: " . "\e[1;37m" . $this->name . "\e[0m\n";
        echo "Уровень: " . "\e[1;37m" . $this->level . "\e[0m\n";
        echo "Раса: " . "\e[1;37m" . $this->race . "\e[0m\n";
        echo "Текущее здоровье: " . "\e[1;32m" . $this->currentHealth . "/" . $this->maxHealth . "\e[0m\n";
        echo "Урон: " . "\e[1;31m" . $this->damage . "\e[0m\n";
        echo "Удача: " . "\e[1;33m" . $this->luck . "\e[0m\n";
        echo "Броня: " . "\e[1;37m" . $this->armor . "\e[0m\n";
        echo "Крит. урон: " . "\e[1;37m" . $this->critDamage . "%\e[0m\n";
        echo "Крит. шанс: " . "\e[1;37m" . $this->critChance . "%\e[0m\n";
    }

    public function showEquipment()
    {
        $number = 1;
        echo $number++ . ". " . "Шлем: " . "\e[1;37m" . $this->equipment["Helmet"]->name . "\e[0m\n";
        echo $number++ . ". " . "Нагрудник: " . "\e[1;37m" . $this->equipment["Chest"]->name . "\e[0m\n";
        echo $number++ . ". " . "Плащ: " . "\e[1;37m" . $this->equipment["Cape"]->name . "\e[0m\n";
        echo $number++ . ". " . "Перчатки: " . "\e[1;37m" . $this->equipment["Gloves"]->name . "\e[0m\n";
        echo $number++ . ". " . "Поножи: " . "\e[1;37m" . $this->equipment["Leggs"]->name . "\e[0m\n";
        echo $number++ . ". " . "Ботинки: " . "\e[1;37m" . $this->equipment["Boots"]->name . "\e[0m\n";
        echo $number++ . ". " . "Левая рука: " . "\e[1;37m" . $this->equipment["LeftHand"]->name . "\e[0m\n";
        echo $number++ . ". " . "Правая рука: " . "\e[1;37m" . $this->equipment["RightHand"]->name . "\e[0m\n";
        echo $number++ . ". " . "Кольцо (1): " . "\e[1;37m" . $this->equipment["FirstRing"]->name . "\e[0m\n";
        echo $number++ . ". " . "Колько (2): " . "\e[1;37m" . $this->equipment["SecondRing"]->name . "\e[0m\n";
        echo $number++ . ". " . " Акссесуар: " . "\e[1;37m" . $this->equipment["Trinket"]->name . "\e[0m\n";
    }

    public function changeEquipment($slot)
    {
        $this->inventory->checkInventory($slot, true);
        $equipableItems =  $this->inventory->getEquipableItems($slot);
        $chosedEquip = (int)readline('Выберите экипировку: ');
        switch (true) {
            case ($chosedEquip >= 1 && $chosedEquip <= count($equipableItems)):
                $item = $equipableItems[--$chosedEquip];
                $this->equip($item, $slot);
                break;
            default:
                echo "Не правильно выбран предмет\n";
                break;
        }
    }

    public function changeEquipmentMenu()
    {
        $loop = true;
        $this->showEquipment();
        while ($loop) {
            echo "Какую экипировку вы хотите изменить? \n";

            switch ((int)readline('Выберите экипировку: ')) {
                case 1:
                    $this->changeEquipment("Helmet");
                    $loop = false;
                    break;
                case 2:
                    $this->changeEquipment("Chest");
                    break;
                case 3:
                    $this->changeEquipment("Cape");
                    $loop = false;
                    break;
                case 4:
                    $this->changeEquipment("Gloves");
                    $loop = false;
                    break;
                case 5:
                    $this->changeEquipment("Leggs");
                    $loop = false;
                    break;
                case 6:
                    $this->changeEquipment("Boots");
                    $loop = false;
                    break;
                case 7:
                    $this->changeEquipment("Weapon");
                    $loop = false;
                    break;
                case 8:
                    $this->changeEquipment(["Weapon", "Shield"]);
                    $loop = false;
                    break;
                case 9:
                    $this->changeEquipment("Ring");
                    $loop = false;
                    break;
                case 10:
                    $this->changeEquipment("Ring");
                    $loop = false;
                    break;
                case 11:
                    $this->changeEquipment("Trinket");
                    $loop = false;
                    break;
                default:
                    $loop = false;
                    break;
            }
        }
    }
}
