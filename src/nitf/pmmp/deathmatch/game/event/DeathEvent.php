<?php

namespace nitf\pmmp\deathmatch\game\event;

use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerDeathEvent;
use nitf\pmmp\deathmatch\member\MemberRepository;
use nitf\pmmp\deathmatch\event\MemberFightEvent;

class DeathEvent implements Listener{

    public function event(PlayerDeathEvent $event): void{
        $player = $event->getPlayer();
        $death_cause = $player->getLastDamageCause();
        if (!MemberRepository::isMember($player)){
            return;
        }
        $member_damaged = MemberRepository::get($player);
        if (!$death_cause instanceof EntityDamageByEntityEvent){
            $member_damaged->respawn();
            return;
        }
        $damager = $death_cause->getDamager();
        if (!$damager instanceof Player){
            return;
        }
        $member_damager = MemberRepository::get($damager);
        if ($member_damaged->getArena()->getName() !== $member_damager->getArena()->getName()){
            return;
        }
        (new MemberFightEvent($this))->call();
        $member_damaged->addDeath();
        $member_damaged->respawn();
        $member_damager->addKill();
    }
}
