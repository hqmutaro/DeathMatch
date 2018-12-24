<?php

namespace nitf\pmmp\deathmatch\game;

use nitf\pmmp\deathmatch\arena\Arena;
use nitf\pmmp\deathmatch\team\Team;
use nitf\pmmp\deathmatch\team\TeamManager;

class GameImpl implements Game{

    /** @var Arena $arena */
    private $arena;

    /** @var Team $team */
    private $team;

    private $is_started = false;

    public function __construct(Arena $arena){
        $this->arena = $arena;
        $this->team = TeamManager::get($arena->getName());
    }

    public function start(): void{
        $this->is_started = true;
    }

    public function finish(): void{
        $this->is_started = false;
    }

    public function isStarted(): bool{
        return $this->is_started;
    }

    public function getTeam(): Team{
        return $this->team;
    }

    public function getName(): string{
        return $this->arena->getName();
    }

    public function getArena(): Arena{
        return $this->arena;
    }
}
