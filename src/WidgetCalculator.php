<?php

namespace WallysWidgets;

class WidgetCalculator
{
    private $solver;

    public function __construct($packageSizes)
    {
        sort($packageSizes);
        $this->solver = new RecursiveSolver($packageSizes);
    }

    /**
     * Calculate the optimal amount of packages for:
     *   1) the fewest amount of widgets necessary to fulfil the order
     *   2) the smallest amount of packages to fulfil the above amount of widgets.
     */
    public function calculatePackages($target)
    {
        $solution = $this->solver->solve($target);

        return $this->formatSolution($solution);
    }

    private static function formatSolution($solution)
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
