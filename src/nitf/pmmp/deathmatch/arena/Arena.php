<?php

namespace nitf\pmmp\deathmatch\arena;

use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use nitf\pmmp\deathmatch\team\Team;
use nitf\pmmp\deathmatch\team\TeamManager;

class Arena{

    private static $plugin;

    /** @var string $arena */
    private $arena;
    
    /** @var Config $config */
    private $setting;

    public static function init(Plugin $plugin): void{
        self::$plugin = $plugin;
    }

    public function __construct(string $arena_name){
        $this->arena = $arena_name;
        $team_settings = [
            'name-tag' => '%NAME%',
            'name-display' => '%NAME%',
            'spawn-pos' => [
                'x' => 0,
                'y' => 0,
                'z' => 0
            ],
            'weapon' => ['267:0'],
            'armor' => [
                'helmet' => 298,
                'chestplate' => 299,
                'leggings' => 300,
                'boots' => 301
            ]
        ];
        $this->createConfig($team_settings);
        TeamManager::register(new Team($this));
    }

    private function createConfig(array $team_settings): void{
        $arena_config = new Config(self::$plugin->getDataFolder() . 'arenas/' . $this->arena . '.yml', Config::YAML, [
            'time-limit' => 200,
            'max-member' => 10,
            'mini-member' => 2,
            'team' => [
                'red' => $team_settings,
                'blue' => $team_settings,
                'green' => $team_settings,
                'yellow' => $team_settings,
            ],
            'protect-world' => true
        ]);
        $this->setting = $arena_config;
    }
    
    public function getConfig(): Config{
        return $this->setting;
    }

    public function getName(): string{
        return $this->arena;
    }
}
