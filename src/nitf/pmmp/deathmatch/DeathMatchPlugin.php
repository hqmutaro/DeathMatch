<?php

namespace nitf\pmmp\deathmatch;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use nitf\pmmp\member\MemberRepository;

class DeathMatchPlugin extends PluginBase{

    private const VERSION = '0.1';
    private const API_VERSION = '3.0.0';

    private static $instance = null;

    protected function onLoad(): void{
        self::$instance = $this;
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        if ($label === 'debug'){
            MemberRepository::getMember($sender)->entry();
            return true;
        }
        return false;
    }

    public static function getInstance(): ?self{
        return self::$instance;
    }
}
