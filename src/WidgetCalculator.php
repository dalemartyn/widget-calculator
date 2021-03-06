<?php

namespace WallysWidgets;

class WidgetCalculator
{
    private $solver;

    public function __construct(array $packageSizes)
    {
        sort($packageSizes);
        $this->solver = new TreeSolver($packageSizes);
    }

    /**
     * Calculate the optimal amount of packages for:
     *   1) the fewest amount of widgets necessary to fulfil the order
     *   2) the smallest amount of packages to fulfil the above amount of widgets.
     */
    public function calculatePackages(int $target)
    {
        $solution = $this->solver->solve($target);

        return $this->formatSolution($solution);
    }

    /**
     * Group the packages.
     *  e.g [5000 => 2, 2000 => 1]
     */
    private static function formatSolution(array $solution)
    {
        $s = [];

        foreach ($solution as $size) {
            if (array_key_exists($size, $s)) {
                $s[$size] += 1;
            } else {
                $s[$size] = 1;
            }
        }

        return $s;
    }
}
