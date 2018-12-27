<?php

namespace nitf\pmmp\deathmatch\game;

class GameManager{
    
    /** @var array<Game> $games */
    private static $games = [];

    public static function register(Game $game): void{
        self::$games[$game->getName()] = $game;
    }

    public static function unregister(Game $game): void{
        unset(self::$games[$game->getName()]);
    }

    public static function get(string $name): ?Game{
        return self::$games[$name];
    }

    public static function getAll(): ?array{
        return self::$games;
    }

    public static function matching(?string $game_name): ?Game{
        if (empty($game_name)){
            foreach (self::$games as $game){
                if ($game->isStarted()){
                    continue;
                }
                return $game;
            }
            return null;
        }
        if (empty(self::get($game_name))){
            return null;
        }
        if (self::get($game_name)->isStarted()){
            return null;
        }
        return self::$games[$game_name];
    }
}
