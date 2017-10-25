<?php
/**
 *   _____            _____      _       _            _____  ______ 
 *  / ____|          |  __ \    (_)     | |          |  __ \|  ____|
 * | |  __  ___ _ __ | |__) |_ _ _ _ __ | |_ ___ _ __| |__) | |__   
 * | | |_ |/ _ \ '_ \|  ___/ _` | | '_ \| __/ _ \ '__|  ___/|  __|  
 * | |__| |  __/ | | | |  | (_| | | | | | ||  __/ |  | |    | |____ 
 *  \_____|\___|_| |_|_|   \__,_|_|_| |_|\__\___|_|  |_|    |______|
 * Pocketmine Generator for Earth and heightmap based generation.
 *
 * Copyright (C) Ad5001 2017
 * 
 * @author Ad5001
 * @api 3.0.0
 * @copyright 2017 Ad5001
 * @license NTOSL - View LICENSE.md
 * @version 1.0.0
 * @package GenPainterPE
 */

namespace Ad5001\GenPainterPE;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\Utils;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\Listener;
use pocketmine\level\generator\Generator;
use pocketmine\level\generator\biome\Biome;

use Ad5001\GenPainterPE\utils\Range;
use Ad5001\GenPainterPE\generator\GenPainter;


class Main extends PluginBase implements Listener{

    public static $GENERATOR_IDS = 0;
    public static $BIOMES_BY_RANGE = [];

    /**
     * Loads the plugin
     *
     * @return void
     */
    public function onEnable(){
        @mkdir($this->getDataFolder());
        @mkdir($this->getDataFolder() . "tmp");
        @mkdir($this->getDataFolder() . "heightmaps");
        $this->saveDefaultConfig();
        if(!file_exists($this->getDataFolder() . "heightmaps/big_5400x2700.png")) file_put_contents($this->getDataFolder() . "heightmaps/big_5400x2700.png", $this->getResource("big_5400x2700.png"));
        if(!file_exists($this->getDataFolder() . "heightmaps/normal_1000x500.png")) file_put_contents($this->getDataFolder() . "heightmaps/normal_1000x500.png", $this->getResource("normal_1000x500.png"));
        if(!file_exists($this->getDataFolder() . "heightmaps/small_250x150.png")) file_put_contents($this->getDataFolder() . "heightmaps/small_250x150.png", $this->getResource("small_250x150.png"));
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        // Register generators
        Generator::addGenerator(GenPainter::class, "genpainter");
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


    /**
     * Called when the plugin disables
     */
    public function onDisable() {
        foreach(array_diff(scandir($this->getDataFolder() . "tmp"), ["..", "."]) as $link){
            unlink($this->getDataFolder() . "tmp/" . $link);
        }
    }


    /**
     * Checks when a world will start being generated to give it's id to it and start generation
     *
     * @param EntityLevelChangeEvent $ev
     * @return void
     */
    public function onEntityLevelChange(EntityLevelChangeEvent $event){
        if($event->getTarget()->getProvider()->getGenerator() == "worldpainter" &&
        $event->getEntity() instanceof Player){
            $spawnpoint = json_decode(
                file_get_contents(
                    get_cwd() . "/worlds/" . $event->getTarget()->getFolderName() . "/gendata/geninfos.json"
                )
            )->startPoint;
			$event->getEntity()->setSpawn(new Position($spawnpoint[0], $spawnpoint[1], $spawnpoint[2], $event->getTarget()));
		}
	}

    /**
     * Generates all ranges for biomes.
     * Default WATER_HEIGHT is 100.
     * Sorry for the formating, but it's the crisis.
     * Big screens are too expensive.
     *
     * @return void
     */
    public static function generateRanges(){
        self::$BIOMES_BY_RANGE = [];
        self::$BIOMES_BY_RANGE[Biome::OCEAN] = new Range(
            GenPainter::MIN_HEIGHT, 
            GenPainter::WATER_HEIGHT);
        self::$BIOMES_BY_RANGE[Biome::RIVER] = new Range(GenPainter::WATER_HEIGHT, 
            GenPainter::WATER_HEIGHT + (17 * GenPainter::DEPTH_MULTIPLICATOR));
        self::$BIOMES_BY_RANGE[Biome::SWAMP] = new Range(GenPainter::WATER_HEIGHT, 
            GenPainter::WATER_HEIGHT + (17 * GenPainter::DEPTH_MULTIPLICATOR));
        self::$BIOMES_BY_RANGE[Biome::DESERT] = new Range(
            GenPainter::WATER_HEIGHT + (8 * GenPainter::DEPTH_MULTIPLICATOR), 
            GenPainter::WATER_HEIGHT + (52 * GenPainter::DEPTH_MULTIPLICATOR));
        self::$BIOMES_BY_RANGE[Biome::ICE_PLAINS] = new Range(
            GenPainter::WATER_HEIGHT + (17 * GenPainter::DEPTH_MULTIPLICATOR), 
            GenPainter::WATER_HEIGHT + (46 * GenPainter::DEPTH_MULTIPLICATOR));
        self::$BIOMES_BY_RANGE[Biome::PLAINS] = new Range(
            GenPainter::WATER_HEIGHT + (17 * GenPainter::DEPTH_MULTIPLICATOR), 
            GenPainter::WATER_HEIGHT + (52 * GenPainter::DEPTH_MULTIPLICATOR));
        self::$BIOMES_BY_RANGE[Biome::FOREST] = new Range(
            GenPainter::WATER_HEIGHT + (40 * GenPainter::DEPTH_MULTIPLICATOR), 
            GenPainter::WATER_HEIGHT + (78 * GenPainter::DEPTH_MULTIPLICATOR));
        self::$BIOMES_BY_RANGE[Biome::BIRCH_FOREST] = new Range(
            GenPainter::WATER_HEIGHT + (40 * GenPainter::DEPTH_MULTIPLICATOR), 
            GenPainter::WATER_HEIGHT + (78 * GenPainter::DEPTH_MULTIPLICATOR));
        self::$BIOMES_BY_RANGE[Biome::TAIGA] = new Range(
            GenPainter::WATER_HEIGHT + (52 * GenPainter::DEPTH_MULTIPLICATOR), 
            GenPainter::WATER_HEIGHT + (78 * GenPainter::DEPTH_MULTIPLICATOR));
        self::$BIOMES_BY_RANGE[Biome::SMALL_MOUNTAINS] = new Range(
            GenPainter::WATER_HEIGHT + (78 * GenPainter::DEPTH_MULTIPLICATOR), 
            GenPainter::WATER_HEIGHT + (158 * GenPainter::DEPTH_MULTIPLICATOR));
        self::$BIOMES_BY_RANGE[Biome::MOUNTAINS] = new Range(
            GenPainter::WATER_HEIGHT + (158 * GenPainter::DEPTH_MULTIPLICATOR), 
            GenPainter::WATER_HEIGHT + (258 * GenPainter::DEPTH_MULTIPLICATOR));
    }


    /**
     * Prompts the command line for a message
     *
     * @param string $message
     * @return void
     */
    public static function prompt(string $message): string{
        if (PHP_OS == 'WINNT') {
            echo $message;
            $line = stream_get_line(STDIN, 1024, PHP_EOL);
        } else {
            $line = readline($message);
        }
        return $line;
    }
}