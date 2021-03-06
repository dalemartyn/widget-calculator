<?php

namespace WallysWidgets;

use PHPUnit\Framework\TestCase;

class WidgetCalculatorTest extends TestCase
{
    public function testCalculator(): void
    {
        $calculator = new WidgetCalculator([
            250,
            500,
            1000,
            2000,
            5000
        ]);
        $this->assertSame($calculator->calculatePackages(1), [250 => 1]);
        $this->assertSame($calculator->calculatePackages(250), [250 => 1]);
        $this->assertSame($calculator->calculatePackages(251), [500 => 1]);
        $this->assertSame($calculator->calculatePackages(501), [500 => 1, 250 => 1]);
        $this->assertSame($calculator->calculatePackages(2250), [2000 => 1, 250 => 1]);
        $this->assertSame($calculator->calculatePackages(12001), [5000 => 2, 2000 => 1, 250 => 1]);

        $calculator = new WidgetCalculator([
            250,
            500,
            1000,
            1999,
            2000,
            5000
        ]);
        $this->assertSame($calculator->calculatePackages(2999), [1999 => 1, 1000 => 1]);
    }
}
