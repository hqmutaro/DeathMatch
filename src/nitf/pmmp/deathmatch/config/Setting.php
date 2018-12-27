<?php

namespace nitf\pmmp\deathmatch\config;

use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;

class Setting{

    /** @var Config $config */
    private static $config;

    public static function init(Plugin $plugin): void{
        self::$config = new Config($plugin->getDataFolder() . 'config.yml', Config::YAML, [
           'enable-arena' => [
               'world',
           ],
           'matching-time' => 60,
           'lobby' => [
               'x' => 0,
               'y' => 0,
               'z' => 0,
               'level' => 'world'
           ],
           'auto-setting' => true
        ]);
    }

    public static function getConfig(): Config{
        return self::$config;
    }
}
