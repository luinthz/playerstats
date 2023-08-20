<?php

namespace pocketlogs\lu\logs;


use pocketlogs\lu\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class joinquit implements Listener{


    public function TesDansLaDbOuQuoi($p): bool
    {
        $db = Main::getInstance()->getDatabase();

        $query = "SELECT COUNT(*) as count FROM Stats WHERE player = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $p);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return $count > 0;
    }

    public function addScoreJoin($p): void
    {
        $db = Main::getInstance()->getDatabase();
        $query = "SELECT * FROM Stats WHERE player = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $p);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if($result) {
            $joinc = $result['JoinCount'] + 1;
            $query = "UPDATE Stats SET JoinCount = + ? WHERE player = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $joinc, $p);
            $stmt->execute();
            $stmt->close();
        }
    }
    public function onJoin(PlayerJoinEvent $event): void
    {
        $db = Main::getInstance()->getDatabase();
        $player = $event->getPlayer();
        $p = $player->getName();
        if ($this->TesDansLaDbOuQuoi($p)) {
            $this->addScoreJoin($p);
            $time = date('Y-m-d H:i:s');
            $query = "INSERT INTO Stats (player, LastLogin, JoinCount, FirstLogin) VALUES ('$p', '$time', 0, 0) ON DUPLICATE KEY UPDATE LastLogin = '$time'";
            $db->query($query);$time = date('Y-m-d H:i:s');
        } else {
            $time = date('Y-m-d H:i:s');
            $query = "INSERT INTO Stats (player, FirstLogin, LastLogin, JoinCount) VALUES ('$p', '$time', 0, 0);";
            $db->query($query);
        }
    }
    public function onQuit(PlayerQuitEvent $event){
        $db = Main::getInstance()->getDatabase();

        $player = $event->getPlayer();
        $p = $player->getName();
        $time = date('Y-m-d H:i:s');
        $query = "UPDATE Stats SET LastLogin = '$time' WHERE player = '$p';";
        $db->query($query);
    }

    public function onPlayerJoin(PlayerJoinEvent $event) {
        $db = Main::getInstance()->getDatabase();

        $player = $event->getPlayer();
        $p = $player->getName();

        if ($this->TesDansLaDbOuQuoi($p)) {
            return;
        } else {
            $time = date('Y-m-d H:i:s');
            $query = "INSERT INTO Stats WHERE player(player, FirstLogin, LastLogin, JoinCount) VALUES ('$p', '$time', 0, 0);";
            $db->query($query);
        }
    }
}