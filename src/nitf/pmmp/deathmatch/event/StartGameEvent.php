<?php

namespace nitf\pmmp\deathmatch\event;

use pocketmine\event\Cancellable;
use pocketmine\event\Event;
use nitf\pmmp\deathmatch\game\Game;

class StartGameEvent extends Event implements Cancellable{

    /** @var Game $game */
    private $game;

    public function __construct(Game $game){
        $this->game = $game;
    }

    public function getGame(): Game{
        return $this->game;
    }
}
