<?php

namespace Blaz3rd\Skypixel\command;

use Blaz3rd\Skypixel\form\SkypixelForm;
use Blaz3rd\Skypixel\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class SkypixelCommand extends PluginCommand
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
        $form = new SkypixelForm(Main::getInstance());
        $form->init($sender);
        return true;
    }

}
