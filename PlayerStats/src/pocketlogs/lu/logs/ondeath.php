<?php


namespace pocketlogs\lu\logs;


use pocketlogs\lu\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;

class ondeath implements Listener{


    public function addDeathCount($p): void
    {
        $db = Main::getInstance()->getDatabase();
        $query = "SELECT * FROM Stats WHERE player = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $p);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if($result) {
            $joinc = $result['DeathCount'] + 1;
            $query = "UPDATE Stats SET DeathCount = + ? WHERE player = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $joinc, $p);
            $stmt->execute();
            $stmt->close();
        }
    }
    public function Death(PlayerDeathEvent $event){
        $player = $event->getPlayer();
        $p = $player->getName();
        $this->addDeathCount($p);
    }

}