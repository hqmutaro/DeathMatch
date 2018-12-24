<?php

namespace nitf\pmmp\deathmatch\game;

use pocketmine\scheduler\Task;
use nitf\pmmp\deathmatch\arena\Arena;
use nitf\pmmp\deathmatch\arena\ArenaManager;
use nitf\pmmp\deathmatch\config\Setting;

class MatchingTask extends Task{

    private $count = 0;

    /** @var Arena $arena */
    private $arena;

    /** @var Game $game */
    private $game;

    public function __construct(Arena $arena){
        $this->arena = $arena;
        $this->count = Setting::getConfig()->get('matching-time');
        GameManager::register(new GameImpl($arena));
        $this->game = GameManager::get($this->arena->getName());
    }

    public function onRun(int $tick): void{
        if ($this->count <= 0){
            if ($this->game->getTeam()->isEmptyMember()){
                $this->getHandler()->cancel();
                return;
            }
            $this->game->start();
            $this->getHandler()->cancel();
            return;
        }
        if ($this->game->getTeam()->isFullMember()){
            $this->game->start();
            $this->getHandler()->cancel();
            return;
        }
        $this->count--;
    }
}
