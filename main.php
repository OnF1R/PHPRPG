<?php
require_once __DIR__ . '/vendor/autoload.php';

use GameEnemy\FireMage;
use GameLogic\Game;

$game = new Game;

$player = $game->createHero();

$game->adventure($player);

// $enemy = new Enemy(3, 'Orc' , 'Name');

// echo $enemy->health . PHP_EOL;