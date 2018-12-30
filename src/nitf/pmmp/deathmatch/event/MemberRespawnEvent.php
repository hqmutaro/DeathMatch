<?php

namespace nitf\pmmp\deathmatch\event;

use pocketmine\event\Cancellable;
use pocketmine\event\Event;
use nitf\pmmp\deathmatch\member\Member;

class MemberRespawnEvent extends Event implements Cancellable{

    /** @var Member $member */
    private $member;

    public function __construct(Member $member){
        $this->member = $member;
    }

    public function getMember(): Member{
        return $this->member;
    }
}
