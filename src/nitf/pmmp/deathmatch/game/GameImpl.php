<?php

namespace nitf\pmmp\deathmatch\game;

class GameImpl implements Game{

    /** @var Arena $arena */
    private $arena;

    /** @var Team $team */
    private $team;

    private $is_started = false;

    public function __construct(Area $area){
        $this->arena = $arena;
        $this->team = TeamManager::get($arena->getName());
    }

    public function start(): void{
        $this->is_started = true;
    }

    public function finish(): void{
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
}
