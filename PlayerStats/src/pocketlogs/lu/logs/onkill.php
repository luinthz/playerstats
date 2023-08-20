<?php


namespace pocketlogs\lu\logs;

use pocketlogs\lu\Main;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\player\Player;

class onkill implements Listener{

    public function addScoreKill($p): void
    {
        $db = Main::getInstance()->getDatabase();
        $query = "SELECT * FROM Stats WHERE player = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $p);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if($result) {
            $kill = $result['KillCount'] + 1;
            $query = "UPDATE Stats SET KilLCount = + ? WHERE player = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $kill, $p);
            $stmt->execute();
            $stmt->close();
        }
    }
    public function OnKill(PlayerDeathEvent $event)
    {
        $player = $event->getPlayer();
        $source = $player->getLastDamageCause();
        if ($source instanceof EntityDamageByEntityEvent) {
            $damager = $source->getDamager();
            if ($damager instanceof Player) {
                $p = $player->getName();
                $damagername = $damager->getName();
                $this->addScoreKill($damagername);
            }
        }

    }
    }