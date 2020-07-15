<?php

namespace WallysWidgets;

class RecursiveSolver extends AbstractSolver
{
    private const PACKAGE_LIMIT = 10;

    public function solve(int $target)
    {
        $this->solution = null;
        $this->solveBranch($target, []);
        return $this->solution;
    }

    /**
     * Recursive function used to calculate the solutions.
     */
    private function solveBranch(int $target, array $initialPackages)
    {
        $packSizes = $this->getPackageSizes($target);
        foreach ($packSizes as $packSize) {
            $packages = $initialPackages;
            $packages[] = $packSize;
            $newTarget = $target - $packSize;

            if ($newTarget <= 0) {
                $this->maybeCacheSolution($packages);
                continue;
            } else {
                if (count($packages) < self::PACKAGE_LIMIT) {
                    $this->solveBranch($newTarget, $packages);
                }
            }
        }
    }

    /**
     * Cache our solution if its better than the current solution.
     */
    private function maybeCacheSolution(array $packages)
    {
        if (
            !$this->solution ||
            $this->isBetterSolution($packages, $this->solution)
        ) {
            $this->solution = $packages;
        }
    }

    private function isBetterSolution(array $packages, array $currentPackages)
    {
        $widgets = array_sum($packages);
        $currentWidgets = array_sum($currentPackages);

        if ($widgets < $currentWidgets) {
            return true;
        }

        if (
            $widgets == $currentWidgets &&
            count($packages) < count($currentPackages)
        ) {
            return true;
        }

        return false;
    }
}
