<?php

namespace nitf\pmmp\deathmatch\game;

use pocketmine\scheduler\Task;

class TimeCountTask extends Task{

    /** @var Game $game */
    private $game;

    private $count = 0;

    public function __construct(Game $game, int $count){
        $this->count = $count;
        $this->game = $game;
    }

    public function onRun(int $tick): void{
        if ($this->count <= 0){
            $this->game->finish();
            $this->getHandler()->cancel();
            return;
        }
        $this->count--;
    }
}
