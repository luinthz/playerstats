<?php


namespace pocketlogs\lu\logs;


use pocketlogs\lu\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJumpEvent;

class onjump implements Listener {


    public function addScoreJump($p): void
    {
        $db = Main::getInstance()->getDatabase();
        $query = "SELECT * FROM Stats WHERE player = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $p);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if($result) {
            $jump = $result['JumpCount'] + 1;
            $query = "UPDATE Stats SET JumpCount = + ? WHERE player = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $jump, $p);
            $stmt->execute();
            $stmt->close();
        }
    }

    public function onJump(PlayerJumpEvent $event) : void
    {
        $player = $event->getPlayer();
        $p = $player->getName();
        $this->addScoreJump($p);
    }

}