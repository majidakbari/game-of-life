<?php

namespace Tests\Entities;

use App\Entities\Cell;
use App\Entities\Grid;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GridTest extends TestCase
{
    public function testInBoundsShouldReturnTrueWhenTheGivenCellIsInsideTheGrid(): void
    {
        // arrange
        $sut = new Grid(10, []);
        $cell = new Cell(5, 0);

        // act
        $actual = $sut->inBounds($cell);

        // assert
        $this->assertTrue($actual);
    }

    #[DataProvider('outBoundCellDataProvider')]
    public function testInBoundsShouldReturnFalseWhenTheGivenCellIsOutsideTheGrid(Cell $cell, int $gridSize): void
    {
        // arrange
        $sut = new Grid($gridSize, []);

        // act
        $actual = $sut->inBounds($cell);

        // assert
        $this->assertFalse($actual);
    }

    public static function outBoundCellDataProvider(): array
    {
        return [
            'x is negative' => [
                new Cell(-1, 0),
                5
            ],
            'x is greater than the grid size' => [
                new Cell(0, 5),
                4
            ],
            'y is negative' => [
                new Cell(0, -2),
                5
            ],
            'y is greater than the grid size' => [
                new Cell(0, 20),
                10
            ],
        ];
    }

    public function testIsAliveShouldReturnTrueWhenTheGivenCellIsAliveInGrid(): void
    {
        // arrange
        $liveCell = new Cell(1, 1);
        $sut = new Grid(10, [$liveCell]);

        // act
        $actual = $sut->isAlive($liveCell);

        // assert
        $this->assertTrue($actual);
    }

    public function testIsAliveShouldReturnFalseWhenTheGivenCellIsNotAliveInGrid(): void
    {
        // arrange
        $liveCell = new Cell(0, 1);
        $sut = new Grid(10, [new Cell(1, 1)]);

        // act
        $actual = $sut->isAlive($liveCell);

        // assert
        $this->assertFalse($actual);
    }
}
