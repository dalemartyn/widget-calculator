<?php

namespace WallysWidgets;

abstract class AbstractSolver
{
    protected $packageSizes;

    public function __construct($packageSizes)
    {
        $this->packageSizes = $packageSizes;
        sort($this->packageSizes);
    }

    abstract public function solve($target);

    /**
     * Get the package sizes relevant to the target.
     * Excludes package sizes that are overly large.
     */
    protected function getPackageSizes($target, $max = INF)
    {
        $sizes = [];

        foreach ($this->packageSizes as $i => $size) {
            $sizes[] = $size;
            if ($size >= $target || $size >= $max) {
                break;
            }
        }

        return array_reverse($sizes);
    }


    /**
     * Get the best solution array of package arrays.
     */
    protected static function getBestSolution($solutions)
    {
        $solutionQuantities = array_map('array_sum', $solutions);
        $closestSolution = min($solutionQuantities);

        $closestSolutions = array_filter(
            $solutions,
            function ($arr) use ($closestSolution) {
                return array_sum($arr) === $closestSolution;
            }
        );

        usort(
            $closestSolutions,
            function ($a, $b) {
                return count($a) > count($b);
            }
        );

        $bestSolution = $closestSolutions[0];
        rsort($bestSolution);

        return $bestSolution;
    }
}
