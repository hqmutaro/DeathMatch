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
        $damaged_member = MemberRepository::get($player);
        if (!$death_cause instanceof EntityDamageByEntityEvent){
            $damaged_member->respawn();
            return;
        }
        $damager = $death_cause->getDamager();
        if (!$damager instanceof Player){
            return;
        }
        $damager_member = MemberRepository::get($damager);
        if ($damaged_member->getArena()->getName() !== $damager_member->getArena()->getName()){
            return;
        }
        (new MemberFightEvent($damaged_member, $damager_member))->call();
        
        $damaged_member->addDeath();
        $damaged_member->respawn();
        $damager_member->addKill();
    }
}
