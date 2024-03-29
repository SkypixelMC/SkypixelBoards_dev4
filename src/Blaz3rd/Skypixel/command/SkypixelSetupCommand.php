<?php

namespace Blaz3rd\Skypixel\command;

use Blaz3rd\Skypixel\entity\FloatingText;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\entity\Entity;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class SkypixelSetupCommand extends PluginCommand
{

    public function __construct(string $name, Plugin $owner)
    {
        parent::__construct($name, $owner);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player) {
            $sender->sendMessage("Please use command in-game");
            return true;
        }
        $a = ["lumberjack", "farmer", "excavation", "miner", "killer", "combat", "builder", "consumer", "archer", "lawnmower"];
        if(count($args) === 0) {
            $sender->sendMessage("Usage: /Skypixeladmin setup ".implode("/" , $a)."> (to spawn floating text) | /Skypixeladmin remove (to remove nearly floating text)");
            return true;
        }
        if($args[0] === "remove") {
            $maxDistance = 3;
            $g = 0;
            foreach($sender->getLevel()->getNearbyEntities($sender->getBoundingBox()->expandedCopy($maxDistance, $maxDistance, $maxDistance)) as $entity){
                if($entity instanceof FloatingText) {
                    $g++;
                    $entity->close();
                }
            }
            $sender->sendMessage("Removed ".$g." floating text");
            return true;
        }
        if($args[0] === "setup") {
            if(!isset($args[1])) {
                $sender->sendMessage("Usage: /Skypixeladmin setup ".implode("/" , $a)."> (to spawn floating text)");
                return true;
            }
            if(!in_array($args[1], $a)) {
                $sender->sendMessage("Usage: /Skypixeladmin setup ".implode("/" , $a)."> (to spawn floating text)");
                return true;
            }
            $nbt = Entity::createBaseNBT($sender->asVector3(), null, $sender->yaw, $sender->pitch);
            $sender->saveNBT();
            $nbt->setTag(clone $sender->namedtag->getCompoundTag("Skin"));
            $a = ["lumberjack" => 0, "farmer" => 1, "excavation" => 2, "miner" => 3, "killer" => 4, "combat" => 5, "builder" => 6, "consumer" => 7, "archer" => 8, "lawnmower" => 9];
            $nbt->setInt("type", $a[$args[1]]);
            $entity = new FloatingText($sender->level, $nbt);
            $entity->spawnToAll();
        }
        return true;
    }

}
