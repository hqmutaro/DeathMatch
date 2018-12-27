<?php

namespace nitf\pmmp\deathmatch;

use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskHandler;

class TaskManager{

    /** @var DeathMatchPlugin $plugin */
    private static $plugin;

    public static function init(DeathMatchPlugin $plugin): void{
        self::$plugin = $plugin;
    }

    public static function repeatingTask(Task $task, int $period): ?TaskHandler{
        return self::$plugin->getScheduler()->scheduleRepeatingTask($task, 20 * $period);
    }

    public static function delayedTask(Task $task, int $delay): ?TaskHandler{
        return self::$plugin->getScheduler()->scheduleRepeatingTask($task, 20 * $delay);
    }
}
