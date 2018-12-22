<?php

namespace nitf\pmmp\deathmatch\member;

use pocketmine\Player;

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
    }

    public function getPlayer(): Player{
        return $this->player;
    }
}
