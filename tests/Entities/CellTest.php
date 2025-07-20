<?php

namespace Tests\Entities;

use App\Entities\Cell;
use PHPUnit\Framework\TestCase;

class CellTest extends TestCase
{
    public function testCoordinatesShouldWork(): void
    {
        // arrange
        $sut = new Cell(100, 20);

        // act
        $actual = $sut->coordinates();

        // assert
        $this->assertSame('100,20', $actual);
    }
}
