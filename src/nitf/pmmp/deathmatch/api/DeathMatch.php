<?php

namespace nitf\pmmp\deathmatch\api;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use nitf\pmmp\deathmatch\game\Game;
use nitf\pmmp\deathmatch\game\GameManager;
use nitf\pmmp\deathmatch\arena\Arena;
use nitf\pmmp\deathmatch\arena\ArenaManager;
use nitf\pmmp\deathmatch\team\Team;
use nitf\pmmp\deathmatch\team\TeamManager;
use nitf\pmmp\deathmatch\member\Member;
use nitf\pmmp\deathmatch\member\MemberRepository;

final class DeathMatch{

    private $plugin;
    private static $plugins = [];
    private static $instance;

    private function __construct(){}

    public static function init(): void{
        self::$instance = new DeathMatch();
    }

    public static function getAPI(DeathMatchAPI $plugin): ?self{
        if (!$plugin instanceof PluginBase){
            return null;
        }
        self::$plugins[] = $plugin->getName();
        return self::$instance;
    }

    public function getGames(): ?array{
        return GameManager::getAll();
    }

    public function getGame(string $game_name): ?Game{
        return GameManager::get($game_name);
    }

    public function matchingGame(?string $game_name): ?Game{
        return GameManager::matching($game_name);
    }

    public function getMember(Player $player): Member{
        return MemberRepository::getMember($player);
    }

    public function unregisterMember(Player $player): void{
        MemberRepository::unregister($player);
    }

    public function isMember(Player $player): bool{
        return MemberRepository::isMember($player);
    }

    public function addMemberToTeam(Arena $arena, string $team_name, Member $member): void{
        $team = TeamManager::get($arena->getName());
        $team->addMember($team_name, $member);
    }

    public function removeMemberFromTeam(Arena $arena, string $team_name, Member $member): void{
        $team = TeamManager::get($arena->getName());
        $team->removeMember($team_name, $member);
    }

    public function getTeam(string $arena_name): ?Team{
        return TeamManager::get($arena_name);
    }

    public function broadcastMessageToTeam(Team $team, string $message): void{
        $team->broadcastMessage($message);
    }

    public function getArenas(): ?array{
        return ArenaManager::getAll();
    }

    public function getArena(string $arena_name): ?Arena{
        return ArenaManager::get($arena_name);
    }

    public function getRandArena(): ?Arena{
        return ArenaManager::getRandArena();
    }

    public function registerArena(Arena $arena): void{
        ArenaManager::register($arena);
    }

    public function unregisterArena(Arena $arena): void{
        ArenaManager::unregister($arena);
    }

    public static function getPlugins(): array{
        return self::$plugins;
    }
}
