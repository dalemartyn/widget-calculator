<?php

namespace WallysWidgets;

class WidgetCalculator
{
    private $packSizes;
    private const RECURSION_LIMIT = 6;

    public function __construct($packSizes)
    {
        $this->packSizes = $packSizes;
        sort($this->packSizes);
    }

    /**
     * Calculate the optimal amount of packages for:
     *   1) the fewest amount of widgets necessary to fulfil the order
     *   2) the smallest amount of packages to fulfil the above amount of widgets.
     */
    public function calculatePackages($target)
    {
        $this->calculateSolutions($target);
        $bestSolution = $this->getBestSolution();

        $this->logSolution($target, $bestSolution);
        return $bestSolution;
    }

    private function logSolution($target, $solution)
    {
        echo("\nTarget: " . $target .  '. Solution: [' . join(',', $solution) . ']');
    }

    /**
     * Calculate the possible solutions.
     */
    private function calculateSolutions($target)
    {
        $this->solutions = [];
        $this->solveBranch($target, []);
    }

    /**
     * Recursive function used to calculate the solutions.
     */
    private function solveBranch($target, $packages)
    {
        $packSizes = $this->getPackSizes($target);
        foreach ($packSizes as $packSize) {
            $iterationPackages = $packages;
            $iterationPackages[] = $packSize;
            $iterationTarget = $target - $packSize;

            if ($iterationTarget <= 0) {
                $this->solutions[] = $iterationPackages;
                continue;
            } else {
                if (count($iterationPackages) < self::RECURSION_LIMIT) {
                    $this->solveBranch($iterationTarget, $iterationPackages);
                }
            }
        }
    }

    /**
     * Get the pack sizes relevant to the target.
     * Excludes pack sizes that are overly large.
     */
    private function getPackSizes($target)
    {
        $packSizes = [];

        foreach ($this->packSizes as $i => $packSize) {
            $packSizes[] = $packSize;
            if ($packSize >= $target) {
                break;
            }
        }

        return array_reverse($packSizes);
    }

    /**
     * Get the best solution from $this->solutions
     */
    private function getBestSolution()
    {
        $solutionQuantities = array_map('array_sum', $this->solutions);
        $closestSolution = min($solutionQuantities);

        $closestSolutions = array_filter(
            $this->solutions,
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
