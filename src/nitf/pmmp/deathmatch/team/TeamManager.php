<?php

namespace nitf\pmmp\deathmatch\team;

class TeamManager{

    /** @var Team $teams */
    private static $teams = [];

    public static function register(Team $team){
        self::$teams[$team->getArena()->getName()] = $team;
    }

    public static function unregister(Team $team){
        unset(self::$teams[$team->getArena()->getName()]);
    }

    public static function get(string $arena): ?Team{
        return self::$teams[$arena];
    }
}
