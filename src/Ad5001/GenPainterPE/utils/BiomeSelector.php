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
 * @package PocketMine-MP (https://github.com/pmmp/PocketMine-MP)
 * @subpackage GenPainterPE
 *
 * Modified version of PocketMine's to allow a better implementation
 */
namespace Ad5001\GenPainterPE\utils;

use pocketmine\level\generator\noise\Simplex;
use pocketmine\utils\Random;
use pocketmine\level\generator\biome\Biome;


class BiomeSelector{
	/** @var Biome */
	private $fallback;
	/** @var Simplex */
	private $temperature;
	/** @var Simplex */
	private $rainfall;
	/** @var Biome[] */
	private $biomes = [];
	/** @var \SplFixedArray */
	private $map = null;
	/** @var callable */
	private $lookup;
	public function __construct(Random $random, callable $lookup, Biome $fallback){
		$this->fallback = $fallback;
		$this->lookup = $lookup;
		$this->temperature = new Simplex($random, 2, 1 / 16, 1 / 512);
		$this->rainfall = new Simplex($random, 2, 1 / 16, 1 / 512);
    }
    
    /**
     * Adds a biome to the selector
     *
     * @param Biome $biome
     * @return void
     */
	public function addBiome(Biome $biome){
		$this->biomes[$biome->getId()] = $biome;
    }
    
    /**
     * Returns the temperature of a biome
     *
     * @param [type] $x
     * @param [type] $z
     * @return void
     */
	public function getTemperature($x, $z){
		return ($this->temperature->noise2D($x, $z, true) + 1) / 2;
    }
    
    /**
     * Returns the rainfall of a location
     *
     * @param int $x
     * @param int $z
     * @return void
     */
	public function getRainfall($x, $z){
		return ($this->rainfall->noise2D($x, $z, true) + 1) / 2;
    }
    
	/**
	 * @param $x
	 * @param $z
	 *
	 * @return Biome
	 */
	public function pickBiome($x, $z) : Biome{
		$temperature = (int) ($this->getTemperature($x, $z) * 63);
		$rainfall = (int) ($this->getRainfall($x, $z) * 63);
        $biomeId = call_user_func($this->lookup, $temperature / 63, $rainfall / 63);
		return $this->biomes[$biomeId] ?? $this->fallback;
	}
}