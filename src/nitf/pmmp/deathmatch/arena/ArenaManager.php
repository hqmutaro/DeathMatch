<?php

namespace nitf\pmmp\deathmatch\arena;

use nitf\pmmp\deathmatch\config\Setting;

class ArenaManager{

    /** @var array<Arena> $arenas */
    private static $arenas = [];

    public static function get(string $arena_name){
        return self::$arenas[$arena_name];
    }

    public static function register(Arena $arena): void{
        self::$arenas[$arena->getName()] = $arena;
    }

    public static function ungister(Arena $arena): void{
        unset(self::$arenas[$arena->getName()]);
    }

    public static function getRandArena(): ?Arena{
        foreach (Setting::getConfig()->get('enable-arena') as $arena_name){
            if (isset(self::$arenas[$arena_name])){
                continue;
            }
            self::register(new Arena($arena_name));
            return self::get($arena_name);
        }
        return null;
    }
}
