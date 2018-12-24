<?php

namespace nitf\pmmp\deathmatch;

use pocketmine\utils\Config;
use pocketmine\plugin\Plugin;

class Messenger{

    /** @var Config $config */
    private static $config;

    public static function init(Plugin $plugin): void{
        self::$config = new Config($plugin->getDataFolder() . 'message.yml', Config::YAML);
        $plugin->saveResource('message.yml');
    }

    public static function get(string $key): string{
        return self::$config->get($key);
    }
}
