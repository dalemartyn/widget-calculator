<?php

namespace WallysWidgets;

abstract class AbstractSolver
{
    protected $packageSizes;

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
    protected function getPackageSizes(int $target)
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
}
