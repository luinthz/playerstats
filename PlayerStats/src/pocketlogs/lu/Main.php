<?php


namespace pocketlogs\lu;

use pocketlogs\lu\cmds\StatsCMD;
use pocketlogs\lu\logs\breakblock;
use pocketlogs\lu\logs\joinquit;
use pocketlogs\lu\logs\ondeath;
use pocketlogs\lu\logs\onemote;
use pocketlogs\lu\logs\onjump;
use pocketlogs\lu\logs\onkill;
use pocketlogs\lu\logs\poseblock;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

    use SingletonTrait;


    private \mysqli $db;
    public function onEnable() : void
    {
        self::setInstance($this, $this);
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->saveResource("database.yml");
        $this->getLogger()->info("[PlayerStats by L.U] -> OKAY");
        $this->connectToDatabase(); // se connecter a la base donnée lorsque le serveur se lance.
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        // Events loading
        $this->getServer()->getPluginManager()->registerEvents(new breakblock(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new poseblock(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new joinquit(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new ondeath(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new onemote(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new onjump(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new onkill(), $this);
        $this->getServer()->getCommandMap()->register("stats", new StatsCMD());
        $this->db->query("CREATE TABLE IF NOT EXISTS Stats (player VARCHAR(255) PRIMARY KEY, Breakblock int, JoinCount int, EmoteCount int, PoseBlock int, DeathCount int, LastLogin datetime, FirstLogin datetime, JumpCount int, KillCount int);");

    }

    public function database(): Config{ // Configuration de la base donnée.
        return new Config($this->getDataFolder(). "database.yml", Config::YAML);
    }

    public function connectToDatabase(): void // Connexion a la base de donnée.
    {
        // Get de la config
        $dt = Main::getInstance()->database();
        $host = $dt->get("host");
        $username = $dt->get("username");
        $password = $dt->get("password");
        $database = $dt->get("database");
        $this->db = new \mysqli($host, $username, $password, $database);
    }

    public function getDatabase(): \mysqli // Get la database dans d'autres fichiers que le main.
    {
        return $this->db;
    }


    public function onDisable(): void // Lorsque le serveur s'éteint, la base de donnée s'arrête.
    {
        $this->db->close();
    }



}