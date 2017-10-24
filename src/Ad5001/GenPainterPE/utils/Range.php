<?php

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