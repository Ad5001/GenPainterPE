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
 * @package BetterGen (https://github.com/Ad5001/BetterGen)
 * @subpackage GenPainterPE
 *
 * Imported from BetterGen (https://github.com/Ad5001/BetterGen/blob/master/src/Ad5001/BetterGen/populator/RavinePopulator.php)
 */

namespace Ad5001\GenPainterPE\populator;

use Ad5001\GenPainterPE\utils\BuildingUtils;
use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\Level;
use pocketmine\utils\Random;

class RavinePopulator extends AmountPopulator {
	/** @var ChunkManager */
	protected $level;
	const NOISE = 250;
	
	/**
	 * Populates the chunk
	 *
	 * @param ChunkManager $level
	 * @param int $chunkX
	 * @param int $chunkZ
	 * @param Random $random
	 * @return void
	 */
	public function populate(ChunkManager $level, $chunkX, $chunkZ, Random $random) {
		$this->level = $level;
		$amount = $this->getAmount($random);
		if ($amount > 50) { // Only build one per chunk
			$depth = $random->nextBoundedInt(60) + 30; // 2Much4U?
			$x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
			$z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
			$y = $random->nextRange(5, $this->getHighestWorkableBlock($x, $z));
			$deffX = $x;
			$deffZ = $z;
			$height = $random->nextRange(15, 30);
			$length = $random->nextRange(5, 12);
			for($i = 0; $i < $depth; $i ++) {
				$this->buildRavinePart($x, $y, $z, $height, $length, $random);
				$diffX = $x - $deffX;
				$diffZ = $z - $deffZ;
				if ($diffX > $length / 2)
					$diffX = $length / 2;
				if ($diffX < - $length / 2)
					$diffX = - $length / 2;
				if ($diffZ > $length / 2)
					$diffZ = $length / 2;
				if ($diffZ < - $length / 2)
					$diffZ = - $length / 2;
				if ($length > 10)
					$length = 10;
				if ($length < 5)
					$length = 5;
				$x += $random->nextRange(0 + $diffX, 2 + $diffX) - 1;
				$y += $random->nextRange(0, 2) - 1;
				$z += $random->nextRange(0 + $diffZ, 2 + $diffZ) - 1;
				$height += $random->nextRange(0, 2) - 1;
				$length += $random->nextRange(0, 2) - 1;
			}
		}
	}
	
	/*
	 * Gets the top block (y) on an x and z axes
	 * @param $x int
	 * @param $z int
	 */
	protected function getHighestWorkableBlock($x, $z) {
		for($y = Level::Y_MAX - 1; $y > 0; -- $y) {
			$b = $this->level->getBlockIdAt($x, $y, $z);
			if ($b === Block::DIRT or $b === Block::GRASS or $b === Block::PODZOL or $b === Block::SAND or $b === Block::SNOW_BLOCK or $b === Block::SANDSTONE) {
				break;
			} elseif ($b !== 0 and $b !== Block::SNOW_LAYER and $b !== Block::WATER) {
				return - 1;
			}
		}
		
		return ++$y;
	}
	
	/**
	 * Buidls a ravine part
	 *
	 * @param int $x
	 * @param int $y
	 * @param int $z
	 * @param int $height
	 * @param int $length
	 * @param Random $random
	 * @return void
	 */
	protected function buildRavinePart($x, $y, $z, $height, $length, Random $random) {
		$xBounded = 0;
		$zBounded = 0;
		for($xx = $x - $length; $xx <= $x + $length; $xx ++) {
			for($yy = $y; $yy <= $y + $height; $yy ++) {
				for($zz = $z - $length; $zz <= $z + $length; $zz ++) {
					$oldXB = $xBounded;
					$xBounded = $random->nextBoundedInt(self::NOISE * 2) - self::NOISE;
					$oldZB = $zBounded;
					$zBounded = $random->nextBoundedInt(self::NOISE * 2) - self::NOISE;
					if ($xBounded > self::NOISE - 2) {
						$xBounded = 1;
					} elseif ($xBounded < - self::NOISE + 2) {
						$xBounded = -1;
					} else {
						$xBounded = $oldXB;
					}
					if ($zBounded > self::NOISE - 2) {
						$zBounded = 1;
					} elseif ($zBounded < - self::NOISE + 2) {
						$zBounded = -1;
					} else {
						$zBounded = $oldZB;
					}
					if (abs((abs($xx) - abs($x)) ** 2 + (abs($zz) - abs($z)) ** 2) < ((($length / 2 - $xBounded) + ($length / 2 - $zBounded)) / 2) ** 2 && $y > 0 && ! in_array($this->level->getBlockIdAt(( int) round($xx),(int) round($yy),(int) round($zz)), BuildingUtils::TO_NOT_OVERWRITE) && ! in_array($this->level->getBlockIdAt(( int) round($xx),(int) round($yy + 1),(int) round($zz)), BuildingUtils::TO_NOT_OVERWRITE)) {
						$this->level->setBlockIdAt(( int) round($xx),(int) round($yy),(int) round($zz), Block::AIR);
					}
				}
			}
		}
	}
}