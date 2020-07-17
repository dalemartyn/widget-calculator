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
}
