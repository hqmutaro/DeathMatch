<?php

namespace nitf\pmmp\deathmatch\member;

use pocketmine\Player;

class MemberRepository{

    private static $members = [];
    
    public static function getMember(Player $player): Member{
        if (empty(self::$members[$player->getName()])){
            self::register($player);
        }
        return self::$members[$player->getName()]->member;
    }

    public static function unregister(Player $player): void{
        unset(self::$members[$player->getName()]);
    }

    public static function isMember(Player $player): bool{
        return (!empty(self::$members[$player->getName()]));
    }

    public static function register(Player $player): void{
        self::$members[$player->getName()] = new MemberImpl($player);
    }
}

