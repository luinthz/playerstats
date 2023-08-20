<?php


namespace pocketlogs\lu\logs;

use pocketlogs\lu\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerEmoteEvent;

class onemote implements Listener{


    public function AddScoreEmote($p): void
    {
        $db = Main::getInstance()->getDatabase();
        $query = "SELECT * FROM Stats WHERE player = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $p);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if($result) {
            $emote = $result['EmoteCount'] + 1;
            $query = "UPDATE Stats SET EmoteCount = + ? WHERE player = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $emote, $p);
            $stmt->execute();
            $stmt->close();
        }
    }

    public function OnEmote(PlayerEmoteEvent $event): void
    {
        $player = $event->getPlayer();
        $p = $player->getName();
        $this->AddScoreEmote($p);
    }

}