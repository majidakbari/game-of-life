<?php

namespace Commands;

use App\Commands\RunGameCommand;
use App\Domain\GameInterface;
use App\Entities\Cell;
use App\Entities\Grid;
use App\Presentation\PresentationInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;

class RunGameCommandTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testInvokeShouldReturnZeroExitCode(): void
    {
        // arrange
        $gridSize = (int) $_ENV['GRID_SIZE'];
        $center = intdiv($gridSize, 2);
        $glider = [
            new Cell($center - 1, $center),
            new Cell($center, $center + 1),
            new Cell($center + 1, $center - 1),
            new Cell($center + 1, $center),
            new Cell($center + 1, $center + 1),
        ];
        $grid = new Grid($gridSize, $glider);

        $output = $this->createMock(OutputInterface::class);
        $game = $this->createMock(GameInterface::class);
        $game->expects($this->once())->method('advance')->with($grid)->willReturn($grid);
        $presenter = $this->createMock(PresentationInterface::class);
        $presenter->expects($this->once())->method('present')->with($grid);
        $sut = new RunGameCommand($game, $presenter);

        // act
        $actual = $sut->__invoke($output);

        // assert
        $this->assertEquals(0, $actual);
    }
}
