<?php

namespace WallysWidgets;

class PackageNode
{

    public function __construct(int $value, ?PackageNode $parent)
    {
        $this->value = $value;
        $this->parent = $parent;
    }

    public function getPackageList()
    {
        $packages = [$this->value];
        $node = $this;

        while ($node = $node->parent) {
            $packages[] = $node->value;
        }

        rsort($packages);
        return $packages;
    }
}
