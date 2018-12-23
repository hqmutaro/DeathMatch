<?php

namespace nitf\pmmp\deathmatch\team;

class TeamManager{

    /** @var Team $teams */
    private static $teams = [];

    public static function register(Team $team){
        self::$teams[$team->getArena()->getName()] = $team;
    }
}
