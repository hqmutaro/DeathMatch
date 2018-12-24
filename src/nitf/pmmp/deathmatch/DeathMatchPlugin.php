<?php

namespace nitf\pmmp\deathmatch;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use nitf\pmmp\deathmatch\arena\Arena;
use nitf\pmmp\deathmatch\config\Setting;
use nitf\pmmp\deathmatch\member\MemberRepository;
use nitf\pmmp\deathmatch\game\PrepareArenaTask;

class DeathMatchPlugin extends PluginBase{

    private const VERSION = '1.0';
    private const API_VERSION = '3.0.0';

    protected function onLoad(): void{
        Messenger::init($this);
        Arena::init($this);
        Setting::init($this);
        TaskManager::init($this);
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
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        if ($label === 'debug'){
            MemberRepository::getMember($sender)->entry();
            return true;
        }
        return false;
    }
}
