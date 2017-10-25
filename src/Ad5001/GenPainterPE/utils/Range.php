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
 *
 */


namespace Ad5001\GenPainterPE\utils;

class Range {

    /** @var int */
    public $from;
    /** @var int */
    public $to;
    
    /**
     * Creates a Range class
     *
     * @param int $from
     * @param int $to
     */
    public function __construct(int $from, int $to) {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * Check if a number is in the range
     *
     * @param int $toTest
     * @return boolean
     */
    public function isInRange(int $toTest){
        return $this->from <= $toTest && $toTest < $this->to;
    }
}