<?php

namespace nitf\pmmp\deathmatch\event;

use pocketmine\event\Cancellable;
use pocketmine\event\Event;
use nitf\pmmp\deathmatch\member\Member;

class MemberFightEvent extends Event implements Cancellable{

    /** @var Member $damaged_member */
    private $damaged_member;

    /** @var Member $attacked_member */
    private $attacked_member;

    public function __construct(Member $damaged_member, Member $attacked_member){
        $this->damaged_member = $damaged_member;
        $this->attacked_member = $attacked_member;
    }

    public function getDamagedMember(): Member{
        return $this->damaged_member;
    }

    public function getAttackedMember(): Member{
        return $this->attacked_member;
    }
}
