<?php

namespace WallysWidgets;

class TreeSolver extends AbstractSolver
{

    /**
     * This solution uses a branch and bound algorithm.
     * Uses a FIFO queue to do breadth-first search,
     * and searches each branch of the tree structure until it goes over the target.
     */
    public function solve(int $target)
    {
        $this->treePackageSizes = $this->getPackageSizes($target);
        $this->solution = null;
        $this->queue = [];

        $this->addPackages(null);

        /**
         * Do a breadth first search.
         * Take each node off the queue:
         *   Test its solution, and record if its the best,
         *      break if its exactly the target, as we are using breadth-first search
         *      there won't be any solutions with fewer packages.
         *   Then add its children to the queue, unless we are bigger than the target.
         */
        while ($node = $this->pop()) {
            $packages = $node->getPackageList();
            if (array_sum($packages) >= $target) {
                $this->maybeCacheSolution($packages);
            } else {
                $this->addPackages($node);
            }
        }

        return $this->solution;
    }

    private function push(PackageNode $node)
    {
        $this->queue[] = $node;
    }

    private function pop()
    {
        return array_shift($this->queue);
    }

    private function addPackages(?PackageNode $parent)
    {
        $maxPackageValue = $parent ? $parent->value : INF;

        $packageSizes = array_filter(
            $this->treePackageSizes,
            function ($packageValue) use ($maxPackageValue) {
                return $packageValue <= $maxPackageValue;
            }
        );

        foreach ($packageSizes as $packageSize) {
            $node = new PackageNode($packageSize, $parent);
            $this->push($node);
        }
    }
}