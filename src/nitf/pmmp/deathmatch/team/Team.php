<?php

namespace nitf\pmmp\deathmatch\team;

use nitf\pmmp\deathmatch\arena\Arena;
use nitf\pmmp\deathmatch\member\Member;

class Team{

    /** @var Arena $arena */
    private $arena;
    
    private $teams = [];
    
    public function __construct(Arena $arena){
        $this->arena = $arena;
        $this->teams = $arena->getConfig()->get('team');
    }

    public function getTeams(): array{
        return $this->teams;
    }

    public function addMember(string $team_name, Member $member): void{
        $this->teams[$team_name] = $member->getName();
    }

    public function getMember(string $team_name, string $name): ?Member{
        return $this->teams[$team_name][$name];
    }

    public function getAllMembers(string $team_name): array{
        return $this->teams[$team_name];
    }

    public function broadcastMessage(string $message): void{
        foreach ($this->teams as $team_name => $member_names){
            foreach ($member_names as $member_name){
                $member = $this->getMember($team_name, $member_name);
                $member->getPlayer()->sendMessage($message);
            }
        }
    }

    public function removeMember(string $team_name, Member $member): void{
        unset($this->teams[$team_name][$member->getName()]);
    }

    public function getTeamMembers(string $team): array{
        return $this->teams[$team];
    }

    public function matching(?string $team_name): ?string{
        $max_member = $this->arena->getConfig()->get('max-member');
        $mini_member = $this->arena->getConfig()->get('mini-member');
        if (empty($team)){
            foreach ($this->teams as $compare_team){
                foreach ($this->teams as $team){
                    if (key($compare_team) === key($team)){
                        continue;
                    }
                    if (count($compare_team) >= $max_member){
                        continue;
                    }
                    if (count($compare_team) < $mini_member){
                        return key($compare_team);
                    }
                    if (count($compare_team) < count($team)){
                        return key($compare_team);
                    }
                }
            }
            return null;
        }
        if (empty($this->teams[$team_name])){
            return null;
        }
        if (count($this->teams[$team_name]) >= $max_member){
            return null;
        }
        return $team_name;
    }

    public function isFullMember(): bool{
        $max_member = $this->arena->getConfig()->get('max-member');
        foreach ($this->teams as $team){
            if (count($team) < $max_member){
                return false;
            }
            continue;
        }
        return true;
    }

    public function isEmptyMember(): bool{
        $mini_member = $this->arena->getConfig()->get('mini-member');
        foreach ($this->teams as $team){
            if (count($team) >= $mini_member){
                return false;
            }
            continue;
        }
        return true;
    }

    public function getArena(): Arena{
        return $this->arena;
    }
}
