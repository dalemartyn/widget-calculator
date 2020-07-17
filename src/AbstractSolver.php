<?php

namespace WallysWidgets;

abstract class AbstractSolver
{
    private $packageSizes;

    public function __construct(array $packageSizes)
    {
        $this->packageSizes = $packageSizes;
        sort($this->packageSizes);
    }

    abstract public function solve(int $target);

    /**
     * Get the package sizes relevant to the target.
     * Excludes package sizes that are overly large.
     */
    protected function getPackageSizes(?int $target)
    {
        $sizes = [];

        foreach ($this->packageSizes as $i => $size) {
            $sizes[] = $size;
            if ($size >= $target) {
                break;
            }
        }

        return array_reverse($sizes);
    }

    /**
     * Cache our solution if its better than the current solution.
     */
    protected function maybeCacheSolution(array $packages)
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
