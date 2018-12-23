<?php

namespace nitf\pmmp\deathmatch;

use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;

class Setting{

    /** @var Config $config */
    private static $config;

    public static function init(Plugin $plugin): void{
        self::$config = new Config($plugin->getDataFolder() . 'config.yml', Config::YAML, [
           'enable-arena' => [
               'world',
           ]
        ]);
    }

    public static function get(string $key, bool $default = false): string{
        return self::$config->get($key, $default);
    }
}
