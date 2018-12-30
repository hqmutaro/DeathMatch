<?php

namespace nitf\pmmp\deathmatch\event;

use pocketmine\event\Cancellable;
use pocketmine\event\Event;
use nitf\pmmp\deathmatch\game\Game;

class MatchingEvent extends Event implements Cancellable{

    /** @var Game $game */
    private $game;
    private $count;

    public function __construct(Game $game, int $count){
        $this->game = $game;
        $this->count = $count;
    }

    public function getGame(): Game{
        return $this->game;
    }

    public function getCountTime(): int{
        return $this->count;
    }
}
