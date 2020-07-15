<?php

namespace WallysWidgets;

use PHPUnit\Framework\TestCase;

class RecursiveSolverTest extends TestCase
{
    public function testSolver(): void
    {
        $solver = new RecursiveSolver([
            250,
            500,
            1000,
            2000,
            5000
        ]);
        $this->assertSame($solver->solve(1), [250]);
        $this->assertSame($solver->solve(250), [250]);
        $this->assertSame($solver->solve(251), [500]);
        $this->assertSame($solver->solve(501), [500, 250]);
        $this->assertSame($solver->solve(2250), [2000, 250]);
        $this->assertSame($solver->solve(12001), [5000, 5000, 2000, 250]);

        $solver = new RecursiveSolver([
            250,
            500,
            1000,
            1999,
            2000,
            5000
        ]);
        $this->assertSame($solver->solve(2999), [1999, 1000]);
    }
}
