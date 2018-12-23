<?php

namespace nitf\pmmp\deathmatch\member;

use pocketmine\Player;
use nitf\pmmp\deathmatch\team\TeamManager;
use nitf\pmmp\deathmatch\game\GameManager;

class MemberImpl implements Member{

    /** @var Member $member */
    private $member;
    
    /** @var Player $player */
    private $player;

    public function __construct(Player $player){
        $this->member = $this;
        $this->player = $player;
    }

    public function entry(): void{
        $game = GameManager::matching();
        if (empty($game)){
            $this->player->sendMessage("現在マッチング中のゲームが存在しません");
            MemberRepository::unregister($this->player);
            return;
        }
        $team = TeamManager::get($game->getName());
        $team_name = $team->matching();
        if (empty($team)){
            $this->player->sendMessage("現在マッチング中のチームが存在しません");
            MemberRepository::unregister($this->player);
            return;
        }
        $this->player->sendMessage("あなたは " . $game . " の " . $team_name . " に参加しました");
        $team->addMember($team_name, $this);
    }

    public function getPlayer(): Player{
        return $this->player;
    }

    public function getName(): string{
        return $this->player->getName();
    }
}
