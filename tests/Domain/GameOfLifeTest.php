<?php

namespace Tests\Domain;

use App\Domain\GameOfLife;
use App\Entities\Cell;
use App\Entities\Grid;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GameOfLifeTest extends TestCase
{
    /**
     * @param Cell[] $liveCells
     * @param Cell[] $expected
     */
    #[DataProvider('initialStateDataProvider')]
    public function testAdvanceShouldApplyAllTheRulesCorrectly(array $liveCells, int $gridSize, array $expected): void
    {
        // arrange
        $sut = new GameOfLife();
        $grid = new Grid($gridSize, $liveCells);

        // act
        $actual = $sut->advance($grid);

        // assert
        $this->assertInstanceOf(Grid::class, $actual);
        $this->assertEquals($expected, $actual->getLiveCells());
    }

    public static function initialStateDataProvider(): array
    {
        return [
            'no cell is alive' => [
                [],
                25,
                []
            ],
            'random pattern' => [
                [
                    new Cell(0, 0),
                    new Cell(1, 1),
                    new Cell(2, 2),
                    new Cell(3, 3),
                ],
                25,
                [
                    new Cell(1, 1),
                    new Cell(2, 2),
                ]
            ],
            'glider pattern' => [
                [
                    new Cell(4, 5),
                    new Cell(5, 6),
                    new Cell(6, 4),
                    new Cell(6, 5),
                    new Cell(6, 6),
                ],
                10,
                [
                    new Cell(5, 4),
                    new Cell(5, 6),
                    new Cell(6, 5),
                    new Cell(6, 6),
                    new Cell(7, 5),
                ],
            ],
            'All the cells are alive' => [
                [
                    new Cell(0, 0),
                    new Cell(0, 1),
                    new Cell(0, 2),
                    new Cell(0, 3),
                    new Cell(0, 4),
                    new Cell(1, 0),
                    new Cell(1, 1),
                    new Cell(1, 2),
                    new Cell(1, 3),
                    new Cell(1, 4),
                    new Cell(2, 0),
                    new Cell(2, 1),
                    new Cell(2, 2),
                    new Cell(2, 3),
                    new Cell(2, 4),
                    new Cell(3, 0),
                    new Cell(3, 1),
                    new Cell(3, 2),
                    new Cell(3, 3),
                    new Cell(3, 4),
                    new Cell(4, 0),
                    new Cell(4, 1),
                    new Cell(4, 2),
                    new Cell(4, 3),
                    new Cell(4, 4),
                ],
                5,
                [
                    new Cell(0, 0),
                    new Cell(0, 4),
                    new Cell(4, 0),
                    new Cell(4, 4),
                ]
            ]
        ];
    }
}
