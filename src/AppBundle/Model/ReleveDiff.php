<?php

namespace AppBundle\Model;

class ReleveDiff
{
    private $left;

    private $right;

    /**
     * Constructor
     * @param array $left
     * @param array $right
     */
    private function __construct($left, $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    /**
     * Make a new object
     * @param array $left
     * @param array $right
     */
    public static function from($left, $right)
    {
        return new self($left, $right);
    }

    /**
     * @return float
     */
    public function hcDiff()
    {
        return floatval($this->right['hchc']) - floatval($this->left['hchc']);
    }

    /**
     * @return float
     */
    public function hpDiff()
    {
        return floatval($this->right['hchp']) - floatval($this->left['hchp']);
    }

    /**
     * @return float
     */
    public function baseDiff()
    {
        return floatval($this->right['base']) - floatval($this->left['base']);
    }

    /**
     * @return array
     */
    public function left()
    {
        return $this->left;
    }

    /**
     * @return array
     */
    public function right()
    {
        return $this->right;
    }
}
