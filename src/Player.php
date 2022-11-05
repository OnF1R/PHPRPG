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

    private $stats;


    private $equipment;
    private $abilites;
    private $magicAmplification;


    private $luck;
    private $armor;
    private $missChance;
    private $critChance;
    private $critDamage;

    private $isDead;



    public function __construct()
    {
        $this->stats = [
            "Strength" => 1,
            "Agility" => 1,
            "Intelligence" => 1,
        ];

        $this->equipment = [
            "Weapon" => new Weapon("", 0, 0, 0, 0, 0),
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

    public function __set($name, $value)
    {
        $properties = [
            'name',
            'level',
            'maxHealth',
            'currentHealth',
            'damage',
            'race',
            'luck',
            'armor',
            'critChance',
            'critDamage',
            'nextLevelExp',
            'currentExp',
            'isDead',
            'missChance',
            'magicAmplification',
        ]; // разрешенные свойства

        if (in_array($name, $properties)) {
            $this->$name = $value;
        }
    }

    public function __get($name)
    {
        $properties = [
            'name',
            'level',
            'maxHealth',
            'currentHealth',
            'damage',
            'race',
            'luck',
            'armor',
            'critChance',
            'critDamage',
            'nextLevelExp',
            'currentExp',
            'isDead',
            'missChance',
            'magicAmplification',
        ]; // разрешенные свойства

        if (in_array($name, $properties)) {
            return $this->$name;
        }
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

    public function setStats($value, $stat)
    {
        $this->stats[$stat] = $value;
    }

    public function getStats($stat)
    {
        return $this->stats[$stat];
    }

    public function getPassiveAbilities()
    {
        $abilitesArray = [];
        foreach ($this->equipment as $item) {
            if ($item->ability !== null) {
                $abilitesArray[$item->type]['ItemName'] = $item->name;
                $abilitesArray[$item->type]['Ability'] = $item->ability;
            }
        }
        return $abilitesArray;
    }

    public function getWeaponDamage()
    {
        if (isset($this->getEquipment("Weapon")->damage)) {
            return $this->getEquipment("Weapon")->damage;
        } else {
            return 0;
        }
    }


    public function takeExp($exp)
    {
        $this->__set('currentExp', (($this->__get('currentExp') + $exp)));
        if ($this->__get('currentExp') >= $this->__get('nextLevelExp')) {
            $this->__set('currentExp',($this->__get('currentExp') - $this->__get('nextLevelExp')));
            $this->__set('nextLevelExp', (floor($this->__get('nextLevelExp') * 1.3)));
            $this->levelUp();
        } else {
            echo $this->__get('name') . " получил " . $exp . " опыта\n";
        }
    }

    public function healMaxHealth()
    {
        $this->__set('currentHealth', ($this->__get('maxHealth')));
    }

    public function levelUp()
    {
        $this->__set('level',($this->__get('level') + 1));
        $this->healMaxHealth();
        if ($this->__get('level') % 5 == 0) {
            switch (rand(1, 6)) {
                case 1:
                    $this->__set('damage',$this->__get('damage') + 1);
                    echo "Улучшен \e[1;31mурон\e[0m на 1\n";
                    break;
                case 2:
                    $this->__set('maxHealth',$this->__get('maxHealth') + 5);
                    echo "Улучшено \e[1;32mздоровье\e[0m на 5\n";
                    break;
                case 3:
                    $this->__set('luck',$this->__get('luck') + 1);
                    echo "Улучшена \e[1;33mудача\e[0m на 1\n";
                    break;
                case 4:
                    $this->setStats($this->getStats("Strength") + 1, "Strength");
                    echo "Улучшена \e[1;37mсила\e[0m на 1\n";
                    $this->__set('maxHealth',$this->__get('maxHealth') + 3);
                    echo "Улучшено \e[1;32mздоровье\e[0m на 3\n";
                    break;
                case 5:
                    $this->setStats($this->getStats("Agility") + 1, "Agility");
                    echo "Улучшена \e[1;37mловкость\e[0m на 1\n";
                    if (rand(0, 1)) {
                        $this->__set('damage',$this->__get('damage') + 2);
                        echo "Улучшен \e[1;31mурон\e[0m на 2\n";
                    } else {
                        $this->__set('missChance',$this->__get('missChance') + 1);
                        echo "Улучшен \e[1;31mшанс уклониться\e[0m на 1\n";
                    }
                    break;
                case 6:
                    $this->setStats($this->getStats("Intelligence") + 1, "Intelligence");
                    echo "Улучшен \e[1;37mинтеллект\e[0m на 1\n";
                    $this->__set('magicAmplification',$this->__get('magicAmplification') + 1);
                    echo "Улучшено \e[1;31mусилинение способностей\e[0m на 1\n";
                    break;
            }
        }
        echo $this->__get('name') . " повысил уровень, текущий уровень " . $this->__get('level') . "\n";
    }

    public function basicAttack($enemy)
    {
        // if (count($this->getPassiveAbilities()) !== 0) {
        //     $abilitesArray = $this->getPassiveAbilities();
        //     foreach ($abilitesArray as $slotName => $abilityArray) {
        //         var_dump($abilitesArray);
        //     }
        // }

        $weaponDamage = $this->getWeaponDamage();

        if ($this->__get('critChance') >= rand(1, 100)) {
            $dealedDamage = $this->__get('damage') + $weaponDamage + floor(($this->__get('damage') + $weaponDamage) / 100 * $this->__get('critDamage'));
            $enemy->fightLogic($this, $dealedDamage, true);
        } else {
            $dealedDamage = $this->__get('damage') + $weaponDamage;
            $enemy->fightLogic($this, $dealedDamage);
        }
    }

    public function takeDamage($takedDamage, $isCrit = false)
    {


        if (!$isCrit) {
            if ($this->__get('armor') >= rand(1, 100)) {
                $blockedDamage = round($takedDamage / 2);
                $this->__set('currentHealth',$this->__get('currentHealth') - $blockedDamage);
                if ($this->__get('currentHealth') <= 0) {
                    $this->death($this);
                } else {
                    echo $this->__get('name') . " заблокировал удар и получил " . $blockedDamage . " \e[1;31mурона\e[0m, его \e[1;32mздоровье\e[0m " . $this->__get('currentHealth') . "\n";
                }
            } else {
                $this->__set('currentHealth',$this->__get('currentHealth') - $takedDamage);
                if ($this->__get('currentHealth') <= 0) {
                    $this->death($this);
                } else {
                    echo $this->__get('name') . " получил " . $takedDamage . " \e[1;31mурона\e[0m, его \e[1;32mздоровье\e[0m " . $this->__get('currentHealth') . "\n";
                }
            }
        } else {
            $this->__set('currentHealth',$this->__get('currentHealth') - $takedDamage);
            if ($this->__get('currentHealth') <= 0) {
                $this->death($this);
            } else {
                echo $this->__get('name') . " получил \e[1;31mкритический удар \e[0m" . $takedDamage . " \e[1;31mурона\e[0m, его \e[1;32mздоровье\e[0m " . $this->__get('currentHealth') . "\n";
            }
        }
    }

    public function death($player)
    {
        echo "К сожалению " . $this->__get('name') . " \e[1;31mумер\e[0m\n";
        $this->__set('currentHealth',$this->__get('currentHealth'));
        $this->__set('isDead',true);
    }

    public function resurrection()
    {
        $this->__set('isDead',false);
        echo $this->__get('name') . " \e[1;32mвозрождён\e[0m\n";
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
        echo "\e[1;37mХарактеристики\e[0m\n";
        echo "Имя: " . "\e[1;37m" . $this->__get('name') . "\e[0m\n";
        echo "Уровень: " . "\e[1;37m" . $this->__get('level') . "\e[0m\n";
        echo "Сила: " . "\e[1;37m" . $this->getStats("Strength") . "\e[0m\n";
        echo "Ловкость: " . "\e[1;37m" . $this->getStats("Agility") . "\e[0m\n";
        echo "Интеллект: " . "\e[1;37m" . $this->getStats("Intelligence") . "\e[0m\n";
        echo "Опыт: " . "\e[1;37m" . $this->__get('currentExp') . "/" . $this->__get('nextLevelExp') . "\e[0m\n";
        echo "Раса: " . "\e[1;37m" . $this->__get('race') . "\e[0m\n";
        echo "Текущее здоровье: " . "\e[1;32m" . $this->__get('currentHealth') . "/" . $this->__get('maxHealth') . "\e[0m\n";
        echo "Урон: " . "\e[1;31m" . $this->__get('damage') . "\e[0m\n";
        echo "Удача: " . "\e[1;33m" . $this->__get('luck') . "\e[0m\n";
        echo "Броня: " . "\e[1;37m" . $this->__get('armor') . "\e[0m\n";
        echo "Крит. урон: " . "\e[1;37m" . $this->__get('critDamage') . "%\e[0m\n";
        echo "Крит. шанс: " . "\e[1;37m" . $this->__get('critChance') . "%\e[0m\n";
        echo "Шанс уклонения: " . "\e[1;37m" . $this->__get('missChance') . "%\e[0m\n";
        echo "Усиление магии: " . "\e[1;37m" . $this->__get('magicAmplification') . "\e[0m\n";
    }

    public function showEquipment()
    {
        $number = 1;
        echo "\e[1;37mЭкипировка\e[0m\n";
        echo $number++ . ". " . "Шлем: " . "\e[1;37m" . $this->getEquipment("Helmet")->name . "\e[0m\n";
        echo $number++ . ". " . "Нагрудник: " . "\e[1;37m" . $this->getEquipment("Chest")->name . "\e[0m\n";
        echo $number++ . ". " . "Плащ: " . "\e[1;37m" . $this->getEquipment("Cape")->name . "\e[0m\n";
        echo $number++ . ". " . "Перчатки: " . "\e[1;37m" . $this->getEquipment("Gloves")->name . "\e[0m\n";
        echo $number++ . ". " . "Поножи: " . "\e[1;37m" . $this->getEquipment("Leggs")->name . "\e[0m\n";
        echo $number++ . ". " . "Ботинки: " . "\e[1;37m" . $this->getEquipment("Boots")->name . "\e[0m\n";
        echo $number++ . ". " . "Оружие: " . "\e[1;37m" . $this->getEquipment("Weapon")->name . "\e[0m\n";
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
