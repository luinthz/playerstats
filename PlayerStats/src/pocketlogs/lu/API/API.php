<?php
namespace pocketlogs\lu\API;
use pocketlogs\lu\Main;
class API{
    public static function getBreakBlock($pseudo) : mixed
    {
        $db = Main::getInstance()->getDatabase();
        $query = "SELECT BreakBlock FROM Stats WHERE player = '$pseudo'";
        $result = $db->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['BreakBlock'];
        } else {
            return 0;
        }
    }
    public static function getPoseBlock($pseudo) : mixed
    {
        $db = Main::getInstance()->getDatabase();
        $query = "SELECT PoseBlock FROM Stats WHERE player = '$pseudo'";
        $result = $db->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['PoseBlock'];
        } else {
            return 0;
        }
    }
    public static function getKill($pseudo) : mixed
    {
        $db = Main::getInstance()->getDatabase();
        $query = "SELECT KillCount FROM Stats WHERE player = '$pseudo'";
        $result = $db->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['KillCount'];
        } else {
            return 0;
        }
    }
    public static function getDeath($pseudo) : mixed
    {
        $db = Main::getInstance()->getDatabase();
        $query = "SELECT DeathCount FROM Stats WHERE player = '$pseudo'";
        $result = $db->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['DeathCount'];
        } else {
            return 0;
        }
    }
    public static function getEmote($pseudo) : mixed
    {
        $db = Main::getInstance()->getDatabase();
        $query = "SELECT EmoteCount FROM Stats WHERE player = '$pseudo'";
        $result = $db->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['EmoteCount'];
        } else {
            return 0;
        }
    }
    public static function getJoin($pseudo) : mixed
    {
        $db = Main::getInstance()->getDatabase();
        $query = "SELECT JoinCount FROM Stats WHERE player = '$pseudo'";
        $result = $db->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['JoinCount'];
        } else {
            return 0;
        }
    }
    public static function getFirstJoin($pseudo) : mixed
    {
        $db = Main::getInstance()->getDatabase();
        $query = "SELECT FirstLogin FROM Stats WHERE player = '$pseudo'";
        $result = $db->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['FirstLogin'];
        } else {
            return 0;
        }
    }
    public static function getLastJoin($pseudo) : mixed
    {
        $db = Main::getInstance()->getDatabase();
        $query = "SELECT LastLogin FROM Stats WHERE player = '$pseudo'";
        $result = $db->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['LastLogin'];
        } else {
            return 0;
        }
    }
}