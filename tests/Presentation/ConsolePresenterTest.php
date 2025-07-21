<?php

namespace Presentation;

use App\Entities\Cell;
use App\Entities\Grid;
use App\Presentation\ConsolePresenter;
use PHPUnit\Framework\TestCase;

class ConsolePresenterTest extends TestCase
{
    public function testPresentShouldPrintTheResultCorrectly(): void
    {
        // arrange
        ob_start();
        $grid = new Grid(5, [
            new Cell(2, 2),
            new Cell(0, 0),
            new Cell(1, 4),
            new Cell(4, 1),
        ]);
        $sut = new ConsolePresenter();

        // act
        $sut->present($grid);
        $actual = ob_get_clean();

        // assert
        $expected = <<<'GRID'

⬛⬜⬜⬜⬜
⬜⬜⬜⬜⬛
⬜⬜⬛⬜⬜
⬜⬜⬜⬜⬜
⬜⬛⬜⬜⬜

GRID;
        $this->assertSame($expected, $actual);
    }
}
