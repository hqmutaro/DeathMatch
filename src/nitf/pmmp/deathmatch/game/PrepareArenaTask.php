<?php

namespace nitf\pmmp\deathmatch\game;

use pocketmine\scheduler\Task;
use nitf\pmmp\deathmatch\TaskManager;
use nitf\pmmp\deathmatch\arena\ArenaManager;

class PrepareArena extends Task{

    public function onRun(int $tick): void{
        $arena = ArenaManager::getRandArena();
        if (empty($arena)){
            return;
        }
        TaskManager::repeatingTask(new MatchingTask($arena), 20 * 1);
    }
}
