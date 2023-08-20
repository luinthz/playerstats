<?php


namespace pocketlogs\lu\logs;


use pocketlogs\lu\Main;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;

 class breakblock implements Listener
 {

    public function AddScoreBreak($p) : void
    {
        $db = Main::getInstance()->getDatabase();
        $query = "SELECT * FROM Stats WHERE player = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $p);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if($result) {
            $break = $result['BreakBlock'] + 1;
            $query = "UPDATE Stats SET BreakBlock = + ? WHERE player = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $break, $p);
            $stmt->execute();
            $stmt->close();
        }
    }
    public function OnBreak(BlockBreakEvent $event) : void
    {
        $player = $event->getPlayer();
        $p = $player->getName();
        $this->AddScoreBreak($p);


    }

}