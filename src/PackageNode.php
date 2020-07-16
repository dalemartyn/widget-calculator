<?php

namespace WallysWidgets;

class PackageNode
{

    public function __construct($value, $parent)
    {
        $this->value = $value;
        $this->parent = $parent;
    }

    public function getPackageList()
    {
        $packages = [$this->value];

        while ($node = $this->parent) {
            $packages[] = $node;
        }

        return $packages;
    }
}
