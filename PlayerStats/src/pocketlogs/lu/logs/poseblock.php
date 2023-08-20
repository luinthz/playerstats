<?php

namespace pocketlogs\lu\logs;


use pocketlogs\lu\Main;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;

class poseblock implements Listener{

    public function AddScorePose($p): void
    {
        $db = Main::getInstance()->getDatabase();
        $query = "SELECT * FROM Stats WHERE player = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $p);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if($result) {
            $break = $result['PoseBlock'] + 1;
            $query = "UPDATE Stats SET PoseBlock = + ? WHERE player = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $break, $p);
            $stmt->execute();
            $stmt->close();
        }
    }

    public function PoseBlock(BlockPlaceEvent $event){
        $player = $event->getPlayer();
        $p = $player->getName();
        $this->AddScorePose($p);
    }


}