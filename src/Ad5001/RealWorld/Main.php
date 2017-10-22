<?php
namespace Ad5001\RealWorld;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\Utils;
use pocketmine\event\level\LevelInitEvent;
use pocketmine\event\Listener;
use pocketmine\level\generator\Generator;

use Ad5001\RealWorld\utils\Range;
use Ad5001\RealWorld\generator\RealWorld;
use Ad5001\RealWorld\generator\RealWorldLarge;


class Main extends PluginBase implements Listener{
    public static $BIOMES_BY_RANGE = [];

    /**
     * Loads the plugin
     *
     * @return void
     */
    public function onEnable(){
        @mkdir($this->getDataFolder());
        if(!file_exists($this->getDataFolder() . "heightmap.png")) { // Get default world HeightMap
            file_put_contents($this->getDataFolder() . "heightmap.png", $this->getResource("heightmap.png"));
        }
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        // Register generators
        Generator::addGenerator(RealWorld::class, "realworld");
    }

    /**
     * Checks when a command is sent.
     *
     * @param CommandSender $sender
     * @param Command $cmd
     * @param string $label
     * @param array $args
     * @return bool
     */
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
        switch($cmd->getName()){
            case "default":
            break;
        }
        return false;
    }


    // /**
    //  * Checks when a world will start being generated to give it's id to it and start generation
    //  *
    //  * @param LevelInitEvent $ev
    //  * @return void
    //  */
    // public function onLevelInit(LevelInitEvent $ev){
    //     $lvl = $ev->getLevel();
    //     $contents = "";
    //     if(file_exists($this->getDataFolder() . "worldsids.txt")){
    //         $contents = file_get_contents($this->getDataFolder() . "worldsids.txt") . "\n";
    //     }
    //     $contents .= $lvl->getId() . ": " . $lvl->getName();
    //     file_put_contents($this->getDataFolder() . "worldsids.txt")
    // }

    /**
     * Generates all ranges for biomes.
     * Default WATER_HEIGHT is 100
     *
     * @return void
     */
    public static function generateRanges(){
        self::$BIOMES_BY_RANGE = [];
        self::$BIOMES_BY_RANGE[Biome::OCEAN] = new Range(RealWorld::MIN_HEIGHT, RealWorld::WATER_HEIGHT);
        self::$BIOMES_BY_RANGE[Biome::RIVER] = new Range(RealWorld::WATER_HEIGHT, RealWorld::WATER_HEIGHT + 10);
        self::$BIOMES_BY_RANGE[Biome::SWAMP] = new Range(RealWorld::WATER_HEIGHT, RealWorld::WATER_HEIGHT + 10);
        self::$BIOMES_BY_RANGE[Biome::DESERT] = new Range(RealWorld::WATER_HEIGHT + 5, RealWorld::WATER_HEIGHT + 31);
        self::$BIOMES_BY_RANGE[Biome::ICE_PLAINS] = new Range(RealWorld::WATER_HEIGHT + 10, RealWorld::WATER_HEIGHT + 31);
        self::$BIOMES_BY_RANGE[Biome::PLAINS] = new Range(RealWorld::WATER_HEIGHT + 10, RealWorld::WATER_HEIGHT + 31);
        self::$BIOMES_BY_RANGE[Biome::FOREST] = new Range(RealWorld::WATER_HEIGHT + 24, RealWorld::WATER_HEIGHT + 47);
        self::$BIOMES_BY_RANGE[Biome::BIRCH_FOREST] = new Range(RealWorld::WATER_HEIGHT + 24, RealWorld::WATER_HEIGHT + 47);
        self::$BIOMES_BY_RANGE[Biome::TAIGA] = new Range(RealWorld::WATER_HEIGHT + 31, RealWorld::WATER_HEIGHT + 47);
        self::$BIOMES_BY_RANGE[Biome::SMALL_MOUNTAINS] = new Range(RealWorld::WATER_HEIGHT + 47, RealWorld::WATER_HEIGHT + 95);
        self::$BIOMES_BY_RANGE[Biome::MOUNTAINS] = new Range(RealWorld::WATER_HEIGHT + 95, RealWorld::WATER_HEIGHT + 155);
    }
}