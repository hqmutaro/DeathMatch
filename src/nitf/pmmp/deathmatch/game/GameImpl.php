<?php

namespace nitf\pmmp\deathmatch\game;

use pocketmine\Server;
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
    private $rankings = [];

    public function __construct(Arena $arena){
        $this->arena = $arena;
        $this->team = TeamManager::get($arena->getName());
        $this->is_auto = Setting::getConfig()->get('auto-setting');
        $this->server = Server::getInstance();
    }

    public function start(): void{
        $this->is_started = true;
        TaskManager::repeatingTask(new TimeCountTask($this, $this->arena->getConfig()->get('time-limit')), 1);
        foreach ($this->team->getTeams() as $team_name => $player_names){
            $team_settings = $this->arena->getConfig()->get('team')[$team_name];
            foreach ($player_names as $player_name){
                $member = $this->team->getMember($team_name, $player_name);
                if ($this->is_auto){
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
            $team_settings = $this->arena->getConfig()->get('team')[$team_name];
            $kills[$team_name] = 0;
            $deaths[$team_name] = 0;
            foreach ($player_names as $player_name){
                $member = $this->team->getMember($team_name, $player_name);
                $player = $member->getPlayer();
                if ($this->is_auto){
                    $player->getInventory()->clearAll();
                    $player->setNameTag($player->getName());
                    $player->setDisplayName($player->getName());
                }
                $kills[$team_name] += $member->getKill();
                $deaths[$team_name] += $member->getDeath();
                $member->spawnToLobby();
                MemberRepository::unregister($player);
            }
        }
        $this->ranking = arsort($kills);
        if ($this->is_auto){
            $rank = 0;
            foreach ($ranking as $team_name => $kill_count){
                $rank++;
                $this->server->broadcast("{$rank}位: {$team_name} Kills: {$kill_count}");
            }
        }
        TeamManager::unregister($this->team);
        ArenaManager::unregister($this->arena);
        GameManager::unregister($this);
    }

    public function getRanking(): array{
        return $this->ranking;
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
