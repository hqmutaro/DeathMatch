<?php

use nitf\pmmp\deathmatch\arena\Arena;

class Team{

    /** @var Arena $arena */
    private $arena;
    
    private $teams = [];
    
    public function __construct(Arena $arena){
        $this->arena = $arena;
        $this->teams = $arena->getConfig('team');
    }

    public function getTeams(): array{
        return $this->teams;
    }

    public function getArena(): Arena{
        return $this->arena;
    }
}

