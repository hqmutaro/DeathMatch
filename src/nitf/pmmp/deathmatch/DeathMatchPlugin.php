<?php

namespace nitf\pmmp\deathmatch;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use nitf\pmmp\deathmatch\api\DeathMatch;
use nitf\pmmp\deathmatch\api\DeathMatchAPI;
use nitf\pmmp\deathmatch\command\DeathMatch;
use nitf\pmmp\deathmatch\arena\Arena;
use nitf\pmmp\deathmatch\event\DamageEvent;
use nitf\pmmp\deathmatch\event\DeathEvent;
use nitf\pmmp\deathmatch\config\Setting;
use nitf\pmmp\deathmatch\member\MemberRepository;
use nitf\pmmp\deathmatch\game\PrepareArenaTask;

class DeathMatchPlugin extends PluginBase implements DeathMatchAPI{

    private const VERSION = 'BETA-1.0';
    private const API_VERSION = '3.0.0';

    protected function onLoad(): void{
        Messenger::init($this);
        Arena::init($this);
        Setting::init($this);
        TaskManager::init($this);
        DeathMatch::init();
    }

    protected function onEnable(): void{
        $path = $this->getDataFolder();
        if (!file_exists($path)){
            @mkdir($path);
        }
        if(!is_dir($dir = $path . 'arenas/')){
            @mkdir($dir);
        }
        TaskManager::repeatingTask(new PrepareArenaTask(), 20 * 1);
        $this->getServer()->getCommandMap()->register('dmc', new DeathMatchCommand($this));
        $this->getServer()->getPluginManager()->registerEvents(new DamageEvent(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new DeathEvent(), $this);
    }
}
