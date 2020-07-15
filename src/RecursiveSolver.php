<?php

namespace WallysWidgets;

class RecursiveSolver extends AbstractSolver
{
    private const PACKAGE_LIMIT = 6;

    public function solve($target)
    {
        $this->calculateSolutions($target);
        $bestSolution = $this->getBestSolution($this->solutions);
        return $bestSolution;
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
    private function solveBranch($target, $initialPackages)
    {
        $packSizes = $this->getPackageSizes($target);
        foreach ($packSizes as $packSize) {
            $packages = $initialPackages;
            $packages[] = $packSize;
            $newTarget = $target - $packSize;

            if ($newTarget <= 0) {
                $this->solutions[] = $packages;
                continue;
            } else {
                if (count($packages) < self::PACKAGE_LIMIT) {
                    $this->solveBranch($newTarget, $packages);
                }
            }
        }
    }
}
