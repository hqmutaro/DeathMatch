<?php

namespace nitf\pmmp\deathmatch\command;

use pocketmine\plugin\Plugin;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use nitf\pmmp\deathmatch\api\DeathMatch;

class DeathMatchCommand extends Command{

    /** @var Plugin $plugin */
    private $plugin;

    public function __construct(Plugin $plugin){
        $this->deathmatch = DeathMatch::getAPI($plugin);
        parent::__construct('dmc', 'DeathMatch', '/dmc <join/cancel/stop> <arena/?/arena>');
    }

    public function execute(CommandSender $sender, string $label, array $args): bool{
        switch ($args[0]){
            case 'join':
                $this->deathmatch->getMember($sender)->entry();
                return true;
            case 'cancel':
                $member = $this->deathmatch->getMember($sender);
                $team = $member->getTeam();
                $arena = $member->getArena();
                $this->deathmatch->removeMemberFromTeam($arena, $team, $member);
                return true;
            case 'stop':
                if (!$sender->isOp()){
                    return false;
                }
                if (empty($args[1])){
                    return false;
                }
                $game = $this->deathmatch->getGame($args[1]);
                if (empty($game)){
                    return false;
                }
                $game->finish();
                return true;
        }
    }
}
