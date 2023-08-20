<?php
namespace pocketlogs\lu\forms;
use jojoe77777\FormAPI\SimpleForm;
use pocketlogs\lu\API\API;
use pocketmine\player\Player;
use pocketlogs\lu\Main;
class StatsForm{
    public static function StatsForm($player, string $pseudo) : void
    {
        $form = new SimpleForm(function (Player $player, int $data = null) use ($pseudo) : void {
            if ($data === null) return;

            switch ($data) {

                case 0:
                    break;

                case 1:

                    break;
            }


        });
        $break = API::getBreakBlock($pseudo);
        $pose = API::getPoseBlock($pseudo);
        $kill = API::getKill($pseudo);
        $death = API::getDeath($pseudo);
        $emote = API::getEmote($pseudo);
        $join = API::getJoin($pseudo);
        $firstj = API::getFirstJoin($pseudo);
        $lastj = API::getLastJoin($pseudo);
        $form->setTitle("§f[§5Player§c§lStats§r§f] > By L.U");
        $form->setContent("Voici les statistiques de §2$pseudo :§f\nBlocs cassés : §5§l$break\n§r§fBlocs posés : §5§l$pose\n§f§rMorts : §5§l$death\n§f§rKills : §5§l$kill\n§f§rEmotes : §5§l$emote\n§f§rConnexions : §5§l$join\n§r§fDernière connexion :\n §5§l$lastj\n§5§lPremière connexion :\n §5§l$firstj");
        $form->addButton("§cFermer");
        $form->sendToPlayer($player);

    }
}