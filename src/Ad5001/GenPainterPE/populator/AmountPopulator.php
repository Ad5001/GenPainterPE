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
 * Imported from BetterGen (https://github.com/Ad5001/BetterGen/blob/master/src/Ad5001/BetterGen/populator/AmountPopulator.php)
 */

namespace Ad5001\GenPainterPE\populator;

use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;

abstract class AmountPopulator extends Populator {
	protected $baseAmount = 0;
	protected $randomAmount = 0;
	
	/**
	 * Crosssoftware class for random amount
	 */
	
	/**
	 * Sets the random addition amount
	 * @param $amount int
	 */
	public function setRandomAmount(int $amount) {
		$this->randomAmount = $amount;
	}
	
	/**
	 * Sets the base addition amount
	 * @param $amount int
	 */
	public function setBaseAmount(int $amount) {
		$this->baseAmount = $amount;
	}
	
	/**
	 * Returns the amount based on random
	 *
	 * @param Random $random
	 * @return int
	 */
	public function getAmount(Random $random) {
		return $this->baseAmount + $random->nextRange(0, $this->randomAmount + 1);
	}
	
	/**
	 * Returns base amount
	 *
	 * @return int
	 */
	public function getBaseAmount(): int {
		return $this->baseAmount;
	}
	
	/**
	 * Returns the random additional amount
	 * 
	 * @return int
	 */
	public function getRandomAmount(): int {
		return $this->randomAmount;
	}
}