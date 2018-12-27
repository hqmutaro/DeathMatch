<?php

namespace nitf\pmmp\deathmatch\game;

use pocketmine\item\Item;
use nitf\pmmp\deathmatch\TaskManager;
use nitf\pmmp\deathmatch\arena\Arena;
use nitf\pmmp\deathmatch\team\Team;
use nitf\pmmp\deathmatch\team\TeamManager;

class GameImpl implements Game{

    /** @var Arena $arena */
    private $arena;

    /** @var Team $team */
    private $team;

    private $is_started = false;

    public function __construct(Arena $arena){
        $this->arena = $arena;
        $this->team = TeamManager::get($arena->getName());
    }

    public function start(): void{
        $this->is_started = true;
        TaskManager::repeatingTask(new TimeCountTask($this, $this->arena->getConfig()['time-limit']));
        foreach ($this->team->getTeams() as $team_name => $player_names){
            $team_settings = $this->arena->getConfig()['team'][$team_name];
            foreach ($player_names as $player_name){
                $member = $this->team->getMember($team_name, $player_name);
                if (Setting::getConfig()->get('auto-setting')){
                    $player = $member->getPlayer();
                    $player->getInventory()->clearAll();
                    $player->setNameTag(str_replace('%NAME%', $player->getName(), $team_settings['name-tag']));
                    $player->setDisplayName(str_replace('%NAME%', $player->getName(), $team_settings['display-tag']));
                }
                $member->respawn();
            }
        }
    }

    public function finish(): void{
        $this->is_started = false;
        foreach ($this->team->getTeams() as $team_name => $player_names){
            $team_settings = $this->arena->getConfig()['team'][$team_name];
            foreach ($player_names as $player_name){
                $member = $this->team->getMember($team_name, $player_name);
                $player = $member->getPlayer();
                if (Setting::getConfig()->get('auto-setting')){
                    $player->getInventory()->clearAll();
                    $player->setNameTag($player->getName());
                    $player->setDisplayName($player->getName());
                }
                $member->spawnToLobby();
                MemberRepository::unregister($player);
            }
        }
        TeamManager::unregister($this->team);
        ArenaManager::unregister($this->arena);
        GameManager::unregister($this);
    }

    public function isStarted(): bool{
        return $this->is_started;
    }

    public function getTeam(): Team{
        return $this->team;
    }

    public function getName(): string{
        return $this->arena->getName();
    }

    public function getArena(): Arena{
        return $this->arena;
    }
}
