<?php

namespace nitf\pmmp\deathmatch\game\event;

use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use nitf\pmmp\deathmatch\member\MemberRepository;

class DamageEvent implements Listener{

    public function event(EntityDamageEvent $event): void{
        $entity = $event->getEntity();
        if (!$entity instanceof Player){
            return;
        }
        if (!MemberRepository::isMember($entity)){
            return;
        }
        $member_damaged = MemberRepository::get($entity);
        if (!$event instanceof EntityDamageByEntityEvent){
            return;
        }
        $damager = $event->getDamager();
        if (!$damager instanceof Player){
            return;
        }
        $member_damager = MemberRepository::get($damager);
        if ($member_damaged->getTeam() === $member_damager->getTeam()){
            $event->setCancelled();
            return;
        }
    }
}
