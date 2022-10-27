<?php

namespace GameLogic;

class Player
{
    private $inventory;

    private $name;
    private $level;
    private $maxHealth;
    private $currentHealth;
    private $damage;
    private $race;
    private $nextLevelExp;
    private $currentExp;


    private $equipment;
    private $abilites;


    private $luck;
    private $armor;

    private $critChance;
    private $critDamage;

    private $isDead;



    public function __construct()
    {
        $this->equipment = [
            "LeftHand" => new Weapon("", 0, 0, 0, 0, 0),
            "RightHand" => new Weapon("", 0, 0, 0, 0, 0),
            "Helmet" => new Armor("", 0, 0, 0, 0, 0, 0),
            "Chest" => new Armor("", 0, 0, 0, 0, 0, 0),
            "Gloves" => new Armor("", 0, 0, 0, 0, 0, 0),
            "Leggs" => new Armor("", 0, 0, 0, 0, 0, 0),
            "Boots" => new Armor("", 0, 0, 0, 0, 0, 0),
            "FirstRing" => new Weapon("", 0, 0, 0, 0, 0),
            "SecondRing" => new Weapon("", 0, 0, 0, 0, 0),
            "Cape" => new Armor("", 0, 0, 0, 0, 0, 0),
            "Trinket" => new Weapon("", 0, 0, 0, 0, 0),
        ];
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setLevel($value)
    {
        $this->level = $value;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setMaxHealth($value)
    {
        $this->maxHealth = $value;
    }

    public function getMaxHealth()
    {
        return $this->maxHealth;
    }

    public function setCurrentHealth($value)
    {
        $this->currentHealth = $value;
    }

    public function getCurrentHealth()
    {
        return $this->currentHealth;
    }

    public function setDamage($value)
    {
        $this->damage = $value;
    }

    public function getDamage()
    {
        return $this->damage;
    }

    public function setRace($value)
    {
        $this->race = $value;
    }

    public function getRace()
    {
        return $this->race;
    }

    public function setLuck($value)
    {
        $this->luck = $value;
    }

    public function getLuck()
    {
        return $this->luck;
    }

    public function setArmor($value)
    {
        $this->armor = $value;
    }

    public function getArmor()
    {
        return $this->armor;
    }

    public function setCritChance($value)
    {
        $this->critChance = $value;
    }

    public function getCritChance()
    {
        return $this->critChance;
    }

    public function setCritDamage($value)
    {
        $this->critDamage = $value;
    }

    public function getCritDamage()
    {
        return $this->critDamage;
    }

    public function setNextLevelExp($value)
    {
        $this->nextLevelExp = $value;
    }

    public function getNextLevelExp()
    {
        return $this->nextLevelExp;
    }

    public function setCurrentExp($value)
    {
        $this->currentExp = $value;
    }

    public function getCurrentExp()
    {
        return $this->currentExp;
    }

    public function setIsDead($value)
    {
        $this->isDead = $value;
    }

    public function getIsDead()
    {
        return $this->isDead;
    }

    public function createInventory()
    {
        $this->inventory = new Inventory;
    }

    public function getInventory()
    {
        return $this->inventory;
    }

    public function setEquipment($item, $slot)
    {
        $this->equipment[$slot] = $item;
    }

    public function getEquipment($slot)
    {
        return $this->equipment[$slot];
    }


    public function takeExp($exp)
    {
        $this->setCurrentExp($this->getCurrentExp() + $exp);
        if ($this->getCurrentExp() >= $this->getNextLevelExp()) {
            $this->setCurrentExp($this->getCurrentExp() - $this->getNextLevelExp());
            $this->setNextLevelExp(floor($this->getNextLevelExp() * 1.3));
            $this->levelUp();
        } else {
            echo $this->getName() . " получил " . $exp . " опыта\n";
        }
    }

    public function healMaxHealth()
    {
        $this->setCurrentHealth($this->getMaxHealth());
    }

    public function levelUp()
    {
        $this->setLevel($this->getLevel() + 1);
        $this->healMaxHealth();
        if ($this->getLevel % 5 == 0) {
            switch (rand(1, 3)) {
                case 1:
                    $this->setDamage($this->getDamage() + 1);
                    break;
                case 2:
                    $this->setMaxHealth($this->getMaxHealth() + 5);
                    break;
                case 3:
                    $this->setLuck($this->getLuck() + 1);
                    break;
            }
        }
        echo $this->getName() . " повысил уровень, текущий уровень " . $this->getLevel() . "\n";
    }

    public function basicAttack($enemy)
    {
        if ($this->getCritChance() >= rand(1, 100)) {
            $dealedDamage = $this->getDamage() + floor($this->getDamage() / 100 * $this->getCritDamage());
        } else {
            $dealedDamage = $this->damage;
        }

        $enemy->fightLogic($this, $dealedDamage);
    }

    public function takeDamage($takedDamage, $isCrit = false)
    {
        if (!$isCrit) {
            if ($this->getArmor() >= rand(1, 100)) {
                $blockedDamage = round($takedDamage / 2);
                $this->setCurrentHealth($this->getCurrentHealth() - $blockedDamage);
                if ($this->getCurrentHealth() <= 0) {
                    $this->death($this);
                } else {
                    echo $this->getName() . " заблокировал удар и получил " . $blockedDamage . " \e[1;31mурона\e[0m, его \e[1;32mздоровье\e[0m " . $this->getCurrentHealth() . "\n";
                }
            } else {
                $this->setCurrentHealth($this->getCurrentHealth() - $takedDamage);
                if ($this->getCurrentHealth() <= 0) {
                    $this->death($this);
                } else {
                    echo $this->getName() . " получил " . $takedDamage . " \e[1;31mурона\e[0m, его \e[1;32mздоровье\e[0m " . $this->getCurrentHealth() . "\n";
                }
            }
        } else {
            $this->setCurrentHealth($this->getCurrentHealth() - $takedDamage);
            if ($this->getCurrentHealth() <= 0) {
                $this->death($this);
            } else {
                echo $this->getName() . " получил \e[1;31mкритический удар \e[0m" . $takedDamage . " \e[1;31mурона\e[0m, его \e[1;32mздоровье\e[0m " . $this->getCurrentHealth() . "\n";
            }
        }
    }

    public function death($player)
    {
        echo "К сожалению " . $this->getName() . " \e[1;31mумер\e[0m\n";
        $this->setCurrentHealth($this->getMaxHealth());
        $this->setIsDead(true);
    }

    public function resurrection()
    {
        $this->setIsDead(false);
        echo $this->getName() . " \e[1;32mвозрождён\e[0m\n";
    }

    public function equip($item, $slot)
    {
        if (isset($this->getEquipment($slot)->isEquiped)) {
            $this->getEquipment($slot)->isEquiped = false;
        }

        $this->setEquipment($item, $slot);

        $this->getEquipment($slot)->isEquiped = true;

        echo "Эпикирован предмет " . $this->getEquipment($slot)->name . " (" . $this->getEquipment($slot)->rarity . ")\n";
    }

    public function showStats()
    {
        echo "Имя: " . "\e[1;37m" . $this->getName() . "\e[0m\n";
        echo "Уровень: " . "\e[1;37m" . $this->getLevel() . "\e[0m\n";
        echo "Опыт: " . "\e[1;37m" . $this->getCurrentExp() . "/" . $this->getNextLevelExp() . "\e[0m\n";
        echo "Раса: " . "\e[1;37m" . $this->getRace() . "\e[0m\n";
        echo "Текущее здоровье: " . "\e[1;32m" . $this->getCurrentHealth() . "/" . $this->getMaxHealth() . "\e[0m\n";
        echo "Урон: " . "\e[1;31m" . $this->getDamage() . "\e[0m\n";
        echo "Удача: " . "\e[1;33m" . $this->getLuck() . "\e[0m\n";
        echo "Броня: " . "\e[1;37m" . $this->getArmor() . "\e[0m\n";
        echo "Крит. урон: " . "\e[1;37m" . $this->getCritDamage() . "%\e[0m\n";
        echo "Крит. шанс: " . "\e[1;37m" . $this->getCritChance() . "%\e[0m\n";
    }

    public function showEquipment()
    {
        $number = 1;
        echo $number++ . ". " . "Шлем: " . "\e[1;37m" . $this->getEquipment("Helmet")->name . "\e[0m\n";
        echo $number++ . ". " . "Нагрудник: " . "\e[1;37m" . $this->getEquipment("Chest")->name . "\e[0m\n";
        echo $number++ . ". " . "Плащ: " . "\e[1;37m" . $this->getEquipment("Cape")->name . "\e[0m\n";
        echo $number++ . ". " . "Перчатки: " . "\e[1;37m" . $this->getEquipment("Gloves")->name . "\e[0m\n";
        echo $number++ . ". " . "Поножи: " . "\e[1;37m" . $this->getEquipment("Leggs")->name . "\e[0m\n";
        echo $number++ . ". " . "Ботинки: " . "\e[1;37m" . $this->getEquipment("Boots")->name . "\e[0m\n";
        echo $number++ . ". " . "Левая рука: " . "\e[1;37m" . $this->getEquipment("LeftHand")->name . "\e[0m\n";
        echo $number++ . ". " . "Правая рука: " . "\e[1;37m" . $this->getEquipment("RightHand")->name . "\e[0m\n";
        echo $number++ . ". " . "Кольцо (1): " . "\e[1;37m" . $this->getEquipment("FirstRing")->name . "\e[0m\n";
        echo $number++ . ". " . "Колько (2): " . "\e[1;37m" . $this->getEquipment("SecondRing")->name . "\e[0m\n";
        echo $number++ . ". " . " Акссесуар: " . "\e[1;37m" . $this->getEquipment("Trinket")->name . "\e[0m\n";
    }

    public function changeEquipment($slot)
    {
        $this->inventory->checkInventory($slot, true);
        $equipableItems =  $this->inventory->getEquipableItems($slot);
        $chosedEquip = (int)readline('Выберите экипировку: ');
        switch (true) {
            case ($chosedEquip >= 1 && $chosedEquip <= count($equipableItems)):
                // $item = $equipableItems[--$chosedEquip];
                $this->equip($equipableItems[--$chosedEquip], $slot);
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
