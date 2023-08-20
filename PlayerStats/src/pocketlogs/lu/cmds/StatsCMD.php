<?php
namespace pocketlogs\lu\cmds;

use pocketlogs\lu\forms\StatsForm;
use pocketlogs\lu\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;

class StatsCMD extends Command{
    public function __construct()
    {
        parent::__construct("stats");
        $this->setPermission("stats.cmd");
        $this->setPermissionMessage("T'a pas les perms!");
        $this->setDescription("Utilisation /stats 'pseudo'");
        $this->setUsage("stats");
    }
    public function playerInDatabase($pseudo){
        $db = Main::getInstance()->getDatabase();
        $pseudo = $db->real_escape_string($pseudo);
        $query = "SELECT * FROM Stats WHERE player = '$pseudo'";
            $result = $db->query($query);
        return $result->num_rows > 0;

    }
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if (!$sender instanceof Player) $sender->sendMessage("§cla console peut pas faire de comma de");
        if ($sender->hasPermission("nomdelacommande.cmd") or Server::getInstance()->isOp($sender->getName())) {
           if(count($args) < 1){
               $sender->sendMessage("Utilisation : /stats 'pseudo'");
               return true;
           }
           $pseudo = $args[0];
           if($this->playerInDatabase($pseudo)){
               StatsForm::StatsForm($sender, $pseudo);
           } else{
               $sender->sendMessage("§cLe joueur ne s'est jamais connecté au serveur ou n'existe pas !");
           }


        }
        return false;

    }
}